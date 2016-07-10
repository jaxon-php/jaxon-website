<?php

namespace Grav\Theme;

use Grav\Common\Theme;

class Habitat extends Theme
{
    protected $jaxon = null;
    protected $phpFile = null;

    public static function getSubscribedEvents()
    {
        return [
            'onThemeInitialized' => ['onThemeInitialized', 0],
        ];
    }

    public function onThemeInitialized()
    {
        $config = $this->config();
        /** @var Uri $uri */
        $uri = $this->grav['uri'];
        $route = $config['route'];

        $this->enable([
            'onPageInitialized' => ['onPageInitialized', 0],
            'onPageContentRaw' => ['onPageContentRaw', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);

        if (($route) && $route == substr($uri->path(), 0, strlen($route)))
        {
            $phpDir = $config['php_dir'];
            $webDir = $config['web_dir'];
            $exampleName = strrchr($uri->path(), '/');
            $GLOBALS['web_dir'] = $webDir;

            // Set the file name
            if(in_array($exampleName, ['/laravel', '/symfony', 'zend-framework', '/yii', '/codeigniter']))
            {
                $this->phpFile = $webDir . $exampleName . '/index.php';
            }
            else if($exampleName != '/examples')
            {
                $this->phpFile = $phpDir . $exampleName . '.php';
            }
            // Create an object for Jaxon contents
            $this->jaxon = new \stdClass;
            $this->jaxon->content = '';
            $this->jaxon->css = '';
            $this->jaxon->js = '';
            $this->jaxon->script = '';
        }
    }

    /**
     * Get the PHP page contents.
     */
    public function onPageInitialized()
    {
        if(!$this->jaxon || !$this->phpFile || !file_exists($this->phpFile))
        {
            return;
        }
        ob_start();
        require_once $this->phpFile;
        $this->jaxon->content = ob_get_contents();
        ob_end_clean();

        // Process Jaxon contents
        $jaxon = jaxon();
        if($jaxon->canProcessRequest())
        {
            $this->grav['page']->template('response');
        }
        else
        {
            $this->jaxon->css = $jaxon->getCss();
            $this->jaxon->js = $jaxon->getJs();
            $this->jaxon->script = $jaxon->getScript();
        }
    }

    /**
     * Set the page template.
     */
    public function onPageContentRaw()
    {
        // $this->grav['page']->template('empty');
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
    }

    /**
     * Set needed variable to display Jaxon code.
     */
    public function onTwigSiteVariables()
    {
        $this->grav['twig']->twig_vars['jaxon'] = $this->jaxon;
        // Top parent page
        $root = $this->grav['page']->topParent();
        // The top parent pages have "Pages" as top parent.
        if($root->title() == 'Pages')
        {
            $root = $this->grav['page'];
        }
        $this->grav['twig']->twig_vars['root'] = $root;
    }
}
