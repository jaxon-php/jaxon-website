---
title: The Yii plugin
menu: The Yii plugin
template: jaxon
cache_enable: false
---

This example shows the usage of the [Jaxon plugin for the Yii framework](https://github.com/jaxon-php/jaxon-yii?target=_blank).

The plugin sets up and configures the Jaxon library, and lets the user focus on writing Jaxon classes for his application.

The Jaxon library is configured with a Yii-specific config file, file is located at `config/jaxon.php`.

By default, the Jaxon plugin registers all classes in the `jaxon/` directory of the Yii application, with namespace `\Jaxon\App`.

#### How it works

Install and configure the Jaxon plugin for Yii, as described in the [plugin documentation](https://github.com/jaxon-php/jaxon-yii?target=_blank)

In the framework controller, insert Jaxon-generated code in the page using view functions

```php
use Yii;
use yii\web\Controller;

class DemoController extends Controller
{
    public function actionIndex()
    {
        $jaxon = Yii::$app->getModule('jaxon');
        // Call the Jaxon module
        $jaxon->register();

        return $this->render('index', array(
            'JaxonCss' => $jaxon->css(),
            'JaxonJs' => $jaxon->js(),
            'JaxonScript' => $jaxon->script(),
        ));
    }
}
```

Save the Jaxon files of  the application in the `jaxon` directory

In this example we have two files `Bts.php` and `Pgw.php` in the `jaxon/Test` directory.

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
        $width = 300;
        $html = $this->view->render('test/credit', ['library' => 'Twitter Bootstrap']);
        $this->response->bootstrap->modal("Modal Dialog", $html, $buttons, $width);
    
        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\Yii\Controller
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
