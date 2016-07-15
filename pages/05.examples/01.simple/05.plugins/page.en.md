---
title: Response Plugin
menu: Response Plugin
template: jaxon
cache_enable: false
description: This example shows the use of Jaxon response plugins, by adding javascript notifications and modal windows to the Hello World Class example with the jaxon-bootbox plugin.
---

Using a Jaxon plugin is very simple. After a plugin is installed with Composer, its automatically registers into the Jaxon core library. It can then be accessed in the Jaxon response object, to provide its functionalities to the application.

#### How it works

Install the plugins

```json
"require": {
    "jaxon-php/jaxon-bootbox": "dev-master"
}
```

In the exported classes, get access to plugins via the Response object

```php
class HelloWorld
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
        $xResponse = new Response();
        $xResponse->assign('div2', 'innerHTML', $text);
        // Call the Bootbox plugin
        $xResponse->bootbox->success("div2 text is now $text");
        return $xResponse;
    }

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);
        // Call the Bootbox plugin
        $xResponse->bootbox->success("div2 color is now $sColor");
        return $xResponse;
    }

    public function showDialog()
    {
        $xResponse = new Response();
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $width = 500;
        $xResponse->bootbox->modal("Modal Dialog", "This modal dialog is powered by Bootbox!!", $buttons, $width);
        return $xResponse;
    }
}
```

While exporting classes, set plugins options

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register object
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported classe from javascript
```php
// Select
<select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="JaxonHelloWorld.sayHello(0); return false;">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello(1); return false;">CLICK ME</button>

<button onclick="JaxonHelloWorld.showDialog(); return false;">Bootbox Dialog</button>
```
