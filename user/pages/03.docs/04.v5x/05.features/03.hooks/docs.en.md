---
title: Hooks
menu: Hooks
template: jaxon
---

In addition to [global callbacks](../../requests/php-callbacks.html), Jaxon allows the developer to define callbacks within classes.
To differentiate between them, these ones are called `hooks`.

A hook is a public or protected method of a Jaxon class, that is configured to be automatically called before or after the processing of a Jaxon request to a given method of that class.

The kooks configuration is done either with annotations in classes, or when registering the classes in [the configuration file](../../about/configuration.html), or [with calls to the Jaxon object](../../registrations/namespaces.html).

### Annotations

The `@before` and `@after` annotations allow to configure hooks in Jaxon classes.
They take the name of the method to call as a parameter.

If the annotation is defined on a Jaxon class, the hook will be called when processing a request to any of its methods.

```php
namespace Ns\App;

use Jaxon\App\FuncComponent;

/**
 * @before beforeHook
 */
class FirstClass extends FuncComponent
{
    protected function beforeHook()
    {
    }

    public function doThat()
    {
    }
}
```

If the annotation is defined on a method, the hook will be called only when processing a request to that method.

```php
namespace Ns\App;

use Jaxon\App\FuncComponent;

class SecondClass extends FuncComponent
{
    protected function firstAfterHook()
    {
    }

    protected function secondAfterHook()
    {
    }

    /**
     * @after firstAfterHook
     * @after secondAfterHook
     */
    public function doThat()
    {
    }
}
```

It is possible to pass constant parameters (integers, booleans, or characters) to hooks.
They must be enclosed in square brackets (`[]`) after the method name.

```php
class FirstClass extends FuncComponent
{
    protected function beforeHook()
    {
    }

    /**
     * @before beforeHook [true, 1]
     */
    public function doThis()
    {
    }

    /**
     * @before beforeHook ["string"]
     */
    public function doThat()
    {
    }
}
```

### Configuration

```php
jaxon()->register(Jaxon::CALLABLE_DIR, '/the/dir/path', [
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\FirstClass::class => [
            'functions' => [
                '*' => [
                    '__before' => 'beforeHook'
                ]
            ]
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                'doThat' => [
                    '__after' => ['firstAfterHook', 'secondAfterHook']
                ]
            ]
        ]
    ]
]);
```

```php
    'app' => [
        'directories' => [
            '/the/dir/path' => [
                'namespace' => 'Ns',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'functions' => [
                            '*' => [
                                '__before' => 'beforeHook'
                            ]
                        ]
                    ],
                    \Ns\App\SecondClass::class => [
                        'functions' => [
                            'doThat' => [
                                '__after' => ['firstAfterHook', 'secondAfterHook']
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
```

It is possible to pass constant parameters (integers, booleans, or characters) to hooks.
In this case, the method name must be used as the index and the parameters as the values ​​in the array.

```php
    'doThat' => [
        '__after' => [
            'afterHook1' => ['p1'],
            'afterHook2' => ['p1', 'p2'],
        ],
    ],
```

#### Access to the called method in a hook

If the Jaxon class inherits from one of the component classes, the name and parameters of the function called by the request are returned by calls to `$this->target()->method()` and `$this->target()->args()`.

The `$this->target()` method will return a non-null value only when called in the class that is the target of the Ajax request.
It can be used to perform different actions depending on the method called.
