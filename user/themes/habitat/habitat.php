<?php

namespace Grav\Theme;

use Grav\Common\Page\Page;
use Grav\Common\Theme;
use Grav\Common\Uri;
use Jaxon\App\Ajax\Jaxon;

use function Jaxon\jaxon;
use function getenv;
use function preg_match;
use function renderCodeSource;
use function renderPageSource;

class Habitat extends Theme
{
    /**
     * @var Jaxon
     */
    private $jaxon;

    public static function getSubscribedEvents()
    {
        return [
            'onThemeInitialized' => ['onThemeInitialized', 0],
        ];
    }

    private function loadExample(string $menu, string $slug): array|false
    {
        $examples = $this->config->get('examples.list');
        if(!isset($examples[$menu][$slug]))
        {
            return false;
        }

        $this->jaxon = jaxon();
        $this->grav['twig']->twig_vars['jaxon'] = $this->jaxon;

        $exampleRoot = $this->config->get('examples.root');
        // Add support for environment variables:
        if (preg_match('/env:(.*)/', $exampleRoot, $match)) {
            $exampleRoot = getenv($match[1]);
        }

        require "$exampleRoot/pages/init.php";
        require "$exampleRoot/pages/$slug/code.php";
        return $examples[$menu][$slug];
    }

    public function onThemeInitialized()
    {
        // $config = $this->config();
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

        /** @var Uri */
        $uri = $this->grav['uri'];
        $paths = $uri->paths();
        if(($paths[0] ?? '') === 'examples')
        {
            $isAjaxRequest = ($paths[1] ?? '') === 'ajax';
            [$menu, $slug] = !$isAjaxRequest ? [$paths[1] ?? '', $paths[2] ?? ''] :
                [$uri->query('m'), $uri->query('s')];
            $example = $this->loadExample($menu, $slug);
            if($example === false)
            {
                return;
            }

            // The Jaxon and Grav PSR log package versions are not compatible.
            // The logging then needs to be disabled.
            $this->jaxon->setAppOption('options.logging.enabled', false);

            if($isAjaxRequest)
            {
                // Process the Jaxon ajax request. Grav sends the response.
                $this->jaxon->setOption('core.response.send', false);
                $this->jaxon->processRequest();
                return;
            }

            // Setup the Jaxon library
            $this->jaxon->config()->globals(true);
            $this->jaxon->setOption('js.lib.uri', null);
            $this->jaxon->setOption('core.request.uri', "/examples/ajax?m={$menu}&s={$slug}");

            // Build the example HTML and Js codes.
            $renderer = $this->jaxon->template();
            $this->grav['twig']->twig_vars['example'] = (object)[
                'html' => $renderer->render("examples::{$slug}/page.php"),
                'ready' => $renderer->render("examples::{$slug}/ready.js"),
                'code' => renderCodeSource($slug),
                'page' => renderPageSource($slug),
                'sources' => $example['sources'],
            ];
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
        /** @var Page */
        $currentPage = $this->grav['page'];
        // Top parent page
        if(!($root = $currentPage->topParent()))
        {
            return;
        }

        // The top parent pages have "Pages" as top parent.
        if($root->title() === 'Pages')
        {
            $root = $currentPage;
        }
        $this->grav['twig']->twig_vars['root'] = $root;
    }
}
