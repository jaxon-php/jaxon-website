---
title: Export functions
menu: Export functions
template: jaxon
---

This is how to export a function.

```php
use Jaxon\Jaxon;

function hello_world($isCaps)
{
    if ($isCaps)
        $text = 'HELLO WORLD!';
    else
        $text = 'Hello World!';

    $xResponse = new Response();
    $xResponse->assign('div1', 'innerHTML', $text);

    return $xResponse;
}

$jaxon->register(Jaxon::USER_FUNCTION, "hello_world");
```

After being exported, this function can be called in javascript with the name `jaxon_hello_world()`. The prefix `jaxon_` can be changed using the `core.prefix.function` configuration option.

Here is an example of HTML code that calls the PHP function exported with Jaxon.

```html
<input type="button" value="Say Hello" onclick="jaxon_hello_world(0)" />
```

A method of a class can also be exported as a function. For this, the second parameter of the function `register()` must be an array, as in the following example.

```php
use Jaxon\Jaxon;

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
}

$hello = new HelloWorld;
$jaxon->register(Jaxon::USER_FUNCTION, array("hello_world", $hello, "sayHello"));
```

If the array contains two elements, the exported javascript function will have the same name as the method.

```php
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, "sayHello"));
```
