---
title: The Laravel plugin
menu: The Laravel plugin
template: jaxon
cache_enable: false
description: This example shows the usage of the Jaxon plugin for the Laravel framework.
---

The plugin sets up and configures the Jaxon library, and lets the user focus on writing Jaxon classes for his application.

The Jaxon library is configured with a Laravel-specific config file, file is located at `config/jaxon.php`.

By default, the Jaxon plugin registers all classes in the `app/Jaxon/Controllers/` directory of the Laravel application, with namespace `\Jaxon\App`.

#### How it works

Install and configure the Jaxon plugin for Laravel, as described in the [plugin documentation](https://github.com/jaxon-php/jaxon-laravel?target=_blank)

In the framework controller, insert Jaxon-generated code in the page using view management calls

```php
use LaravelJaxon;

class DemoController extends Controller
{
    public function index()
    {
        // Register the Jaxon classes
        LaravelJaxon::register();
        // Print the page
        return view('index', array(
            'JaxonCss' => LaravelJaxon::css(),
            'JaxonJs' => LaravelJaxon::js(),
            'JaxonScript' => LaravelJaxon::script()
        ));
    }
}
```

Save the Jaxon files of  the application in the `app/Jaxon/Controllers` directory

In this example we have two files `Bts.php` and `Pgw.php` in the `app/Jaxon/Controllers/Test` directory.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Laravel\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div2', 'innerHTML', $text);
        $this->response->toastr->success("div2 text is now $text, after calling " . $this->call('sayHello', $isCaps));
    
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

class Pgw extends \Jaxon\Laravel\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div1', 'innerHTML', $text);
        $this->response->toastr->success("div1 text is now $text, after calling " . $this->call('sayHello', $isCaps));
    
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
