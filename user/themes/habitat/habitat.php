<?php

namespace Grav\Theme;

use Grav\Common\Theme;

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
        // $config = $this->config();
        // /** @var Uri $uri */
        // $uri = $this->grav['uri'];

        $this->enable([
            // 'onPageInitialized' => ['onPageInitialized', 0],
            // 'onPageContentRaw' => ['onPageContentRaw', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);

        // Enable Piwik and Google Analytics only on the website
        if($_SERVER['SERVER_NAME'] !== 'www.jaxon-php.org' || (isset($_GET['a']) && $_GET['a'] === 'no'))
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
        if(!($root = $this->grav['page']->topParent()))
        {
            return;
        }
        // The top parent pages have "Pages" as top parent.
        if($root->title() === 'Pages')
        {
            $root = $this->grav['page'];
        }
        $this->grav['twig']->twig_vars['root'] = $root;
    }
}
