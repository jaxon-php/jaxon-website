---
title: Registering PHP objects and functions
menu: From PHP to javascript
template: jaxon
---

Before a PHP class or function can be called from javascript, it must first be registered.
The `register()` function of Jaxon is used for that purpose.

#### Registering a class instance

An object is registered with Jaxon by calling the `register()` function with the `Jaxon::CALLABLE_OBJECT` parameter.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;

class HelloWorld
{
    public function sayHello($isCaps)
    {
        $response = new Response();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
        return $response;
    }

    public function setColor($sColor)
    {
        $response = new Response();
        $response->assign('div2', 'style.color', $sColor);
        return $response;
    }
}

$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```

After the object is registered, all its public methods are available in a javascript class named `JaxonHelloWorld`.
The prefix `Jaxon` can be changed using the `core.prefix.class` configuration option.

Here is an example of HTML code that calls methods of the PHP class exported with Jaxon.

```html
<input type="button" value="Say Hello" onclick="JaxonHelloWorld.sayHello(0)" />
<input type="button" value="Set Color" onclick="JaxonHelloWorld.setColor('red')" />
```

#### Registering a function

A function is registered with Jaxon by calling the `register()` function with the `Jaxon::USER_FUNCTION` parameter.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;

function hello_world($isCaps)
{
    $response = new Response();
    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div2', 'innerHTML', $text);
    return $response;
}

$jaxon->register(Jaxon::USER_FUNCTION, "hello_world");
```

After it is registered, the function can be called from javascript with the name `jaxon_hello_world()`.
The prefix `jaxon_` can be changed using the `core.prefix.function` configuration option.

Here is an example of HTML code that calls the PHP function registered with Jaxon.

```html
<input type="button" value="Say Hello" onclick="jaxon_hello_world(0)" />
```

A method of a class can also be exported as a function.
In this case, the second parameter of the function `register()` must be an array, as in the following example.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;

class HelloWorld
{
    public function sayHello($isCaps)
    {
        $response = new Response();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
        return $response;
    }
}

$hello = new HelloWorld;
$jaxon->register(Jaxon::USER_FUNCTION, array("hello_world", $hello, "sayHello"));
```

```html
<input type="button" value="Say Hello" onclick="jaxon_hello_world(0)" />
```

If the array contains two elements, the corresponding javascript function will have the same name as the method.

```php
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, "sayHello"));
```

```html
<input type="button" value="Say Hello" onclick="jaxon_sayHello(0)" />
```
