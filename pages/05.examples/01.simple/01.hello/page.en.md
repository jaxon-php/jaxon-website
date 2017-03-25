---
title: Hello World Function
menu: Hello World Function
template: jaxon
cache_enable: false
---

This example shows how to export a function with Jaxon.

#### How it works

Define the functions to be exported

```php
function helloWorld($isCaps)
{
    if ($isCaps)
        $text = 'HELLO WORLD!';
    else
        $text = 'Hello World!';

    $xResponse = new Response();
    $xResponse->assign('div1', 'innerHTML', $text);

    return $xResponse;
}

function setColor($sColor)
{
    $xResponse = new Response();
    $xResponse->assign('div1', 'style.color', $sColor);

    return $xResponse;
}
```

Register the functions with Jaxon

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register functions
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
$jaxon->register(Jaxon::USER_FUNCTION, 'setColor');

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported functions from javascript

```php
// Select
<select id="colorselect" onchange="jaxon_setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="jaxon_helloWorld(0); return false;">Click Me</button>
<button onclick="jaxon_helloWorld(1); return false;">CLICK ME</button>
```
