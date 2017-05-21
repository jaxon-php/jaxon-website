---
title: Hello World Function
menu: Hello World Function
template: jaxon
---

These are the functions to be exported with Jaxon.
Each function creates and returns a `Response` object.

```php
function helloWorld($isCaps)
{
    $response = new Response();

    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div1', 'innerHTML', $text);

    return $response;
}

function setColor($sColor)
{
    $response = new Response();

    $response->assign('div1', 'style.color', $sColor);

    return $response;
}
```
