---
title: The CakePHP plugin
menu: The CakePHP plugin
template: jaxon
cache_enable: false
---

This example shows the usage of the [Jaxon plugin for the CakePHP framework](https://github.com/jaxon-php/jaxon-cake?target=_blank).

The plugin sets up and configures the Jaxon library, and lets the user focus on writing Jaxon classes for his application.

The Jaxon library is configured with a CakePHP-specific config file, file is located at `config/jaxon.php`.

By default, the Jaxon plugin registers all classes in the `ROOT/jaxon/Controller/` directory of the CakePHP application, with namespace `\Jaxon\App`.

#### How it works

Install and configure the Jaxon plugin for CakePHP, as described in the [plugin documentation](https://github.com/jaxon-php/jaxon-cake?target=_blank)

In the framework controller, insert Jaxon-generated code in the page using view functions

```php
namespace App\Controller;

class DemoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // Load the Jaxon component
        $this->loadComponent('Jaxon/Cake.Jaxon');
    }

    public function index()
    {
        // Call the Jaxon module
        $this->Jaxon->register();

        $this->set('jaxonCss', $this->Jaxon->css());
        $this->set('jaxonJs', $this->Jaxon->js());
        $this->set('jaxonScript', $this->Jaxon->script());
        $this->render('demo');
    }
}
```

Save the Jaxon files of  the application in the `app/Jaxon/Controllers` directory

In this example we have two files `Bts.php` and `Pgw.php` in the `ROOT/jaxon/Controller/Test` directory.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Module\Controller
{
    public function sayHello($isCaps)
    {
        $html = $this->view->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div2', 'innerHTML', $html);

        $message = $this->view->render('test/message', [
            'element' => 'div2',
            'attr' => 'text',
            'value' => $html,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function setColor($sColor)
    {
        $this->response->assign('div2', 'style.color', $sColor);

        $message = $this->view->render('test/message', [
            'element' => 'div2',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('width' => 300);
        $html = $this->view->render('test/credit', ['library' => 'Twitter Bootstrap']);
        $this->response->bootstrap->modal("Modal Dialog", $html, $buttons, $options);
    
        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\Cake\Controller
{
    public function sayHello($isCaps)
    {
        $html = $this->view->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div1', 'innerHTML', $html);

        $message = $this->view->render('test/message', [
            'element' => 'div1',
            'attr' => 'text',
            'value' => $html,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function setColor($sColor)
    {
        $this->response->assign('div1', 'style.color', $sColor);

        $message = $this->view->render('test/message', [
            'element' => 'div1',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        $html = $this->view->render('test/credit', ['library' => 'PgwModal']);
        $this->response->pgw->modal("Modal Dialog", $html, $buttons, $options);
    
        return $this->response;
    }
}
```
