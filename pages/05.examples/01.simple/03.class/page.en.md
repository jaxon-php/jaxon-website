---
title: Hello World Class
menu: Hello World Class
template: jaxon
cache_enable: false
description: This example shows how to export a class with Jaxon.
---

#### How it works

Define the class to be exported

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

        return $xResponse;
    }

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);

        return $xResponse;
    }
}
```

Register the classe with Jaxon

```php
// Register object
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported class from javascript

```html
// Select
<select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="JaxonHelloWorld.sayHello(0); return false;">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello(1); return false;">CLICK ME</button>
```
