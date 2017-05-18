<?php

namespace Grav\Theme;

use Grav\Common\Theme;
use stdClass;

class Habitat extends Theme
{
    protected $jaxon = null;

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

        $this->enable([
            'onPageInitialized' => ['onPageInitialized', 0],
            'onPageContentRaw' => ['onPageContentRaw', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);

        // Check if this is an example page (dir is /examples or /demo)
        if (substr($uri->path(), 0, 9) == '/examples' || substr($uri->path(), 0, 5) == '/demo')
        {
            // Set the example URL
            $exampleUrl = trim($uri->base(), '/') . '/exp/';
            $path = trim(strrchr($uri->path(), '/'), '/');
            switch($path)
            {
            // For frameworks, load the pages from the public dir
            case 'laravel':
                $exampleUrl .= 'laravel/';
                break;
            case 'symfony':
                $exampleUrl .= 'symfony/';
                break;
            case 'zend':
                $exampleUrl .= 'zend/';
                break;
            case 'yii':
                $exampleUrl .= 'yii/';
                break;
            case 'codeigniter':
                $exampleUrl .= 'codeigniter/';
                break;
            case 'cake':
                $exampleUrl .= 'cake/';
                break;
            default:
                if($path != 'examples') // /examples is the path to the section
                {
                    $exampleUrl .= $path . '.php';
                }
                break;
            }
            // Create an object for Jaxon contents
            if(($exampleUrl) && ($dom = \html5qp($exampleUrl)))
            {
                $this->jaxon = new stdClass;
                $this->jaxon->html = html_entity_decode($dom->find('#jaxon-html')->eq(0)->innerHTML());
                $this->jaxon->init = html_entity_decode($dom->find('#jaxon-init')->eq(0)->innerHTML());
                $this->jaxon->code = html_entity_decode($dom->find('#jaxon-code')->eq(0)->innerHTML());
            }
        }

        // Enable Piwik and Google Analytics only on the website
        if($_SERVER['SERVER_NAME'] != 'www.jaxon-php.org' || (key_exists('a', $_GET) && $_GET['a'] == 'no'))
        {
            $this->config->set('plugins.piwik.siteId', 0);
            $this->config->set('plugins.ganalytics.trackingId', '');
        }
    }

    /**
     * Get the PHP page contents.
     */
    public function onPageInitialized()
    {}

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
