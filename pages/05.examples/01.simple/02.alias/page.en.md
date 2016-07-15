---
title: Hello World Alias
menu: Hello World Alias
template: jaxon
cache_enable: false
description: This example shows how to export the methods of a class as functions with Jaxon, using aliases.
---

#### How it works

Define the class with methods to be exported

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

Register the methods with Jaxon

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register class methods as Jaxon functions
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, array('helloWorld', $hello, 'sayHello'));
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, 'setColor'));

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported function from javascript

```php
// Select
<select id="colorselect" onchange="jaxon_setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="jaxon_helloWorld(0); return false;">Click Me</button>
<button onclick="jaxon_helloWorld(1); return false;">CLICK ME</button>
```
