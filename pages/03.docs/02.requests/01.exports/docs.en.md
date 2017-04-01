---
title: Export PHP objects and functions
menu: Export PHP code
template: jaxon
---

This is how to export an object.

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

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);

        return $xResponse;
    }
}

$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```

After being exported, all public methods of the object are available in a javascript class named `JaxonHelloWorld`.
The prefix `Jaxon` can be changed using the `core.prefix.class` configuration option.

Here is an example of HTML code that calls methods of the PHP class exported with Jaxon.
```html
<input type="button" value="Say Hello" onclick="JaxonHelloWorld.sayHello(0)" />
<input type="button" value="Set Color" onclick="JaxonHelloWorld.setColor('red')" />
```
