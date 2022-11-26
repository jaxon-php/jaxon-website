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
            // 'onPageInitialized' => ['onPageInitialized', 0],
            // 'onPageContentRaw' => ['onPageContentRaw', 0],
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0]
        ]);

        // Check if this is an example page (dir is /examples or /demo)
        if(!strstr($uri->path(), '/codes/') &&
            (substr($uri->path(), 0, 9) == '/examples' || substr($uri->path(), 0, 5) == '/demo'))
        {
            // Set the example URL
            $exampleUrl = trim($uri->base(), '/') . '/exp/web/';
            $path = trim(strrchr($uri->path(), '/'), '/');
            // For frameworks, load the pages from the public dir
            if($path != 'examples') // /examples is the path to the section
            {
                // Create an object for Jaxon contents
                if(($dom = \html5qp($exampleUrl . $path . '/')))
                {
                    $this->jaxon = new stdClass;
                    $this->jaxon->html = html_entity_decode($dom->find('#jaxon-html')->eq(0)->innerHTML());
                    $this->jaxon->init = html_entity_decode($dom->find('#jaxon-init')->eq(0)->innerHTML());
                    $this->jaxon->code = html_entity_decode($dom->find('#jaxon-code')->eq(0)->innerHTML());
                    // Reset the Jaxon request URI
                    switch($path)
                    {
                    // For all frameworks except CodeIgniter, Set the request URI to the "/jaxon" path.
                    case 'codeigniter':
                        $this->jaxon->code .= "\n" .
                            '<script type="text/javascript" charset="UTF-8">jaxon.config.requestURI = "/exp/web/' .
                            $path . '/jaxon/process";</script>';
                        break;
                    case 'laravel':
                    case 'symfony':
                    case 'zend':
                    case 'yii':
                    case 'cake':
                        $this->jaxon->code .= "\n" .
                            '<script type="text/javascript" charset="UTF-8">jaxon.config.requestURI = "/exp/web/' .
                            $path . '/jaxon";</script>';
                        break;
                    // For the others, Set the request URI to the "/ajax.php" path.
                    default:
                        $this->jaxon->code .= "\n" .
                            '<script type="text/javascript" charset="UTF-8">jaxon.config.requestURI = "/exp/web/' .
                            $path . '/ajax.php";</script>';
                        break;
                    }
                }
            }
        }

        // Enable Piwik and Google Analytics only on the website
        if($_SERVER['SERVER_NAME'] != 'www.jaxon-php.org' || (isset($_GET['a']) && $_GET['a'] === 'no'))
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
        if($root->title() == 'Pages')
        {
            $root = $this->grav['page'];
        }
        $this->grav['twig']->twig_vars['root'] = $root;
    }
}
