---
title: Registering PHP functions
menu: Functions
template: jaxon
---

The `app.functions` section of the configuration contains an array of functions to be registered.

Here's an example.

```php
function hello_world($isCaps)
{
    $response = jaxon()->newResponse();
    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div2', 'innerHTML', $text);
}
```

```php
    'app' => [
        'functions' => [
            'hello_world',
            'sayhello',
        ],
    ],
```

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world");
```

After it is registered, the function can be called from javascript with the name `hello_world()`.

Here's the code that Jaxon will generate and send to the browser.

```js
hello_world = function() {
    return jaxon.request(
        { jxnfun: 'helloWorld' }, { parameters: arguments }
    );
};
```

The javascript function name can be changed to an alias.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["alias" => "sayHello"]);
```

Options can be set on functions.

```php
    'app' => [
        'functions' => [
            'hello_world' => [
                'mode' => "'asynchronous'",
            ],
        ],
    ],
```

A method of a class can also be registered as a function.
In this case, the class name is passed to the `register()` call, as in the following example.

```php
use function Jaxon\jaxon;

class HelloWorld
{
    public function hello_world($isCaps)
    {
        $response = jaxon()->newResponse();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
    }
}
```

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class]);
```

An alias can also be defined.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class, "alias" => "sayHello"]);
```
