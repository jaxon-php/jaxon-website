---
title: Registering PHP classes
menu: Classes
template: jaxon
---

#### The classes

The `app.classes` section of the configuration contains an array of classes to be registered.

Here's an example.

```php
class HelloWorld
{
    public function sayHello($isCaps)
    {
        $response = jaxon()->newResponse();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
    }

    public function setColor($sColor)
    {
        $response = jaxon()->newResponse();
        $response->assign('div2', 'style.color', $sColor);
    }
}
```

```php
    'app' => [
        'classes' => [
            'HelloWorld',
            'OtherClass',
        ],
    ],
```

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```

After the class is registered, all its public methods are available in a javascript class named `HelloWorld`.

Here's the javascript code Jaxon will generate.

```javascript
JaxonHelloWorld = {};
JaxonHelloWorld.sayHello = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'sayHello' }, { parameters: arguments }
    );
};
JaxonHelloWorld.setColor = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'setColor' }, { parameters: arguments }
    );
};
```

#### Setting options

Options can be set on class methods.

```php
    'app' => [
        'classes' => [
            'HelloWorld' => [
                'functions' => [
                    'setColor' => [
                        'mode' => "'synchronous'"
                    ],
                    '*' => [
                        'mode' => "'asynchronous'"
                    ],
                ],
            ],
        ],
    ],
```

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, [
    'functions' => [
        'setColor' => [
            'mode' => "'synchronous'"
        ],
        '*' => [
            'mode' => "'asynchronous'"
        ]
    ]
]);
```

Here's the generated javascript code.

```js
JaxonHelloWorld.sayHello = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'sayHello' }, { parameters: arguments, mode: 'asynchronous' }
    );
};
JaxonHelloWorld.setColor = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'setColor' }, { parameters: arguments, mode: 'synchronous' }
    );
};
```

#### Autoloading a class

When registering a class, the `include` option allows to specify the path to the file where the class is defined.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, ['include' => '/path/to/dir/HelloWorld.php']);
```

This file will be included in the application only if a method of the class is called.
