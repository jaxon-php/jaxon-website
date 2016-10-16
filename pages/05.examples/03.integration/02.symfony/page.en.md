---
title: The Symfony plugin
menu: The Symfony plugin
template: jaxon
cache_enable: false
description: This example shows the usage of the [Jaxon plugin for the Symfony framework](https://github.com/jaxon-php/jaxon-symfony?target=_blank).
---

The plugin sets up and configures the Jaxon library, and lets the user focus on writing Jaxon classes for his application.

The Jaxon library is configured in a file in Yaml format, located at `app/config/jaxon.yml`.
A sample configuration file is available online in [the examples repo](https://github.com/jaxon-php/jaxon-examples/blob/master/frameworks/symfony/app/config/jaxon.yml?target=_blank).

By default, the Jaxon plugin registers all classes in the `src/Jaxon/App/` directory of the Symfony application, with namespace `\Jaxon\App`.

#### How it works

Install and configure the Jaxon plugin for Symfony, as described in the [plugin documentation](https://github.com/jaxon-php/jaxon-symfony?target=_blank)

In the framework controller, insert Jaxon-generated code in the page using view management calls

```php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DemoController extends Controller
{
    public function indexAction(Request $request)
    {
        // Register the Jaxon classes
        $jaxon = $this->get('jaxon.ajax');
        $jaxon->register();
        // Print the page
        return $this->render('demo/index.html.twig',
            'jaxon_css' => $jaxon->css(),
            'jaxon_js' => $jaxon->js(),
            'jaxon_script' => $jaxon->script()
        ]);
    }
}
```

Save the Jaxon files of  the application in the `src/Jaxon/App` directory

In this example we have two files `Bts.php` and `Pgw.php` in the `src/Jaxon/App/Test` directory.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\AjaxBundle\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div2', 'innerHTML', $text);
        $this->response->toastr->success("div2 text is now $text");
    
        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div2', 'style.color', $sColor);
        $this->response->toastr->success("div2 color is now $sColor");
    
        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $width = 300;
        $this->response->bootstrap->modal("Modal Dialog", "This modal dialog is powered by Twitter Bootstrap!!", $buttons, $width);
    
        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\AjaxBundle\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div1', 'innerHTML', $text);
        $this->response->toastr->success("div1 text is now $text");
    
        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div1', 'style.color', $sColor);
        $this->response->toastr->success("div1 color is now $sColor");
    
        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        $this->response->pgw->modal("Modal Dialog", "This modal dialog is powered by PgwModal!!", $buttons, $options);
    
        return $this->response;
    }
}
```
