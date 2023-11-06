---
title: Registering PHP functions
menu: Functions
template: jaxon
---

Before a PHP class or function can be called from javascript, it must first be registered.
The `register()` function of Jaxon is used for that purpose.

A function is registered with Jaxon by calling the `register()` function with the `Jaxon::CALLABLE_FUNCTION` parameter.

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

$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world");
```

After it is registered, the function can be called from javascript with the name `jaxon_hello_world()`.
The prefix `jaxon_` is defined using the `core.prefix.function` configuration option.

Here's the code that Jaxon will generate and send to the browser.

```js
jaxon_hello_world = function() {
    return jaxon.request(
        { jxnfun: 'helloWorld' },
        { parameters: arguments }
    );
};
```

Here is an example of HTML code that calls the PHP function registered with Jaxon.

```html
<input type="button" value="Say Hello" onclick="jaxon_hello_world(0)" />
```

The javascript function name can be changed to an alias.

```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["alias" => "sayHello"]);
```

```html
<input type="button" value="Say Hello" onclick="jaxon_sayHello(0)" />
```

A method of a class can also be registered as a function.
In this case, the class name is passed to the `register()` call, as in the following example.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;

class HelloWorld
{
    public function hello_world($isCaps)
    {
        $response = new Response();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
        return $response;
    }
}

$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class]);
```

```html
<input type="button" value="Say Hello" onclick="jaxon_hello_world(0)" />
```

An alias can also be defined.

```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class, "alias" => "sayHello"]);
```

```html
<input type="button" value="Submit" onclick="jaxon_sayHello()" />
```
