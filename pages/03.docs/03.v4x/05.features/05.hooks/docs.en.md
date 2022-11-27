---
title: Hooks
menu: Hooks
template: jaxon
---

A hook is a public or protected method of a Jaxon class, that is configured to be automatically called before (`__before` hook) or after (`__after` hook) the processing of a Jaxon request to a given method of that class.

### Configuration

The hooks are configured either when registering [a class](../../02.registrations/02.classes/) or [a directory](../../02.registrations/03.directories/), or in the [configuration file](../01.bootstrap/).

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/dir/path', [
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

In the `\Ns\App\FirstClass` class, the `beforeHook()` method will be called before processing a request to any method.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class FirstClass extends CallableClass
{
    protected function beforeHook()
    {
    }

    public function doThat()
    {
        return $this->response;
    }
}
```

In the `\Ns\App\SecondClass` class, the `firstAfterHook()` and `secondAfterHook()` methods will be called after processing a request to the `doThat()` method.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
{
    protected function firstAfterHook()
    {
    }

    protected function secondAfterHook()
    {
    }

    public function doThat()
    {
        return $this->response;
    }
}
```

### Hook parameters

Parameters (constants or arrays of constants) can be passed to hooks while configuring them.

```php
    'doThat' => [
        '__after' => [
            'afterHook1' => ['p1'],
            'afterHook2' => ['p1', 'p2'],
        ],
    ],
```

The name and the parameters of the method that is called by the Jaxon request can also be passed as parameters, using `__method__` and `__args__` as values.

```php
    'doThat' => [
        '__before' => [
            'beforeHook' => ['__method__', '__args__']
        ],
    ],
```

### Annotation

Hooks can also be configured using [the `@before` and `@after` annotations](../../06.annotations/06.hooks/).

If the annotation is defined on a Jaxon class, the hook will be called when processing a request to any of its methods.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

/**
 * @before beforeHook
 */
class FirstClass extends CallableClass
{
    protected function beforeHook()
    {
    }

    public function doThat()
    {
        return $this->response;
    }
}
```

If the annotation is defined on some methods, the hook will be called only when processing a request to these methods.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
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
        return $this->response;
    }
}
```
