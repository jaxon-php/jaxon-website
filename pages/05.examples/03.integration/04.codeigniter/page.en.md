---
title: The CodeIgniter plugin
menu: The CodeIgniter plugin
template: jaxon
cache_enable: false
description: This example shows the usage of the [Jaxon plugin for the CodeIgniter framework](https://github.com/jaxon-php/jaxon-codeigniter?target=_blank).
---

The plugin sets up and configures the Jaxon library, and lets the user focus on writing Jaxon classes for his application.

The Jaxon library is configured with a CodeIgniter-specific config file, located at `config/jaxon.php`.

By default, the Jaxon plugin registers all classes in the `application/jaxon` directory of the CodeIgniter application, with namespace `\Jaxon\App`.

#### How it works

Install and configure the Jaxon plugin for CodeIgniter, as described in the [plugin documentation](https://github.com/jaxon-php/jaxon-codeigniter?target=_blank)

In the framework controller, insert Jaxon-generated code in the page using view management calls

```php
class Demo extends Jaxon_Controller
{
    public function index()
    {
        // Register the Jaxon classes
        $this->jaxon->register();
        // Print the page
        $this->load->library('parser');
        $this->parser->parse('index', array(
            'JaxonCss' => $this->jaxon->css(),
            'JaxonJs' => $this->jaxon->js(),
            'JaxonScript' => $this->jaxon->script()
        ));
    }
}
```

Save the Jaxon files of the application in the `application/jaxon` directory

In this example we have two files `Bts.php` and `Pgw.php` in the `application/jaxon/Test` directory.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\CI\Controller
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
        $width = 300;
        $html = $this->view->render('test/credit', ['library' => 'Twitter Bootstrap']);
        $this->response->bootstrap->modal("Modal Dialog", $html, $buttons, $width);
    
        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\CI\Controller
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
