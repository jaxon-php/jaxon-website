---
title: Exporter les classes dans un namespace
menu: Exporter un namespace
template: jaxon
---

Les classes à exporter sont dans deux namespaces.

Fichier `/jaxon/class/dir/app/Test/Test.php`.

```php
namespace App\Test;

use Jaxon\Response\Response;

class Test
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function sayHello($isCaps)
    {
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $this->response->assign('div1', 'innerHTML', $text);
        $this->response->dialog->success("div1 text is now $text");

        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div1', 'style.color', $sColor);
        $this->response->dialog->success("div1 color is now $sColor");

        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        $this->response->dialog->modal("Modal Dialog", "This modal dialog is powered by PgwModal!!", $buttons, $options);

        return $this->response;
    }
}
```

Fichier `/jaxon/class/dir/ext/Test/Test.php`.

```php
namespace Ext\Test;

use Jaxon\Response\Response;

class Test
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function sayHello($isCaps)
    {
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $this->response->assign('div2', 'innerHTML', $text);
        $this->response->dialog->success("div2 text is now $text");

        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div2', 'style.color', $sColor);
        $this->response->dialog->success("div2 color is now $sColor");

        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('width' => 500);
        $this->response->dialog->modal("Modal Dialog", "This modal dialog is powered by Twitter Bootstrap!!", $buttons, $options);

        return $this->response;
    }
}
```
