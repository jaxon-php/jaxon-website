<?php

namespace Grav\Plugin;

use Grav\Common\Page\Collection;
use Grav\Common\Plugin;
use Grav\Common\Uri;
use Grav\Common\Taxonomy;

use Jaxon\Jaxon;
use Jaxon\Request\Factory as jr;

class JaxonPlugin extends Plugin
{
    protected $jaxon;
    protected $phpFile = null;

    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0],
        ];
    }

    public function onPluginsInitialized()
    {
        /** @var Uri $uri */
        $uri = $this->grav['uri'];
        $route = $this->config->get('plugins.jaxon.route');

        $this->enable([
            // 'onPageInitialized' => ['onPageInitialized', 0],
            // 'onPageContentRaw' => ['onPageContentRaw', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);

        if (($route) && $route == substr($uri->path(), 0, strlen($route)))
        {
            $this->enable([
                'onPageInitialized' => ['onPageInitialized', 0],
                'onPageContentRaw' => ['onPageContentRaw', 0],
                // 'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
                // 'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
            ]);

            $phpDir = $this->config->get('plugins.jaxon.php_dir');
            $webDir = $this->config->get('plugins.jaxon.web_dir');
            $exampleName = strrchr($uri->path(), '/');
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
        if(!$this->phpFile)
        {
            return;
        }
        ob_start();
        require_once $this->phpFile;
        $this->jaxon->content = ob_get_contents();
        ob_end_clean();

        // Process Jaxon contents
        $jaxon = Jaxon::getInstance();
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
