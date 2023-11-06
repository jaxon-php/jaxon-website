---
title: Data bags
menu: Data bags
template: jaxon
---

`Data bags` are data sets that are stored on client side, and made available on demand in Jaxon classes.
They are convenient for data that must be available allover the application, but are only used occasionnally.

Each `data bag` has an identifier which must be unique throughout the application, and each of its data is stored under a key which must be unique throughout the `data bag`.

### Creation

A `data bag` is created by storing a first value in it, in a method of a Jaxon class.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    public function doThat()
    {
        $this->bag('bag_key')->set('value_key', $value);

        return $this->response;
    }
}
```

The `data bag` will then be sent in the Jaxon response, and stored in the application on client side.

### Usage

Before the data in a `data bag` can be read in a method of a Jaxon class, the library must be explicitly configured to embed its content in the requests to that method.

This is done when registering [a class](../../02.registrations/02.classes/) or [a directory](../../02.registrations/03.directories/), or in the [configuration file](../01.bootstrap/).

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/dir/path', [
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\FirstClass::class => [
            'functions' => [
                '*' => [
                    'bags' => ["'bag_key'"]
                ]
            ]
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                'doThat' => [
                    'bags' => ["'bag_key'"]
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
                                'bags' => ["'bag_key'"]
                            ]
                        ]
                    ],
                    \Ns\App\SecondClass::class => [
                        'functions' => [
                            'doThat' => [
                                'bags' => ["'bag_key'"]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
```

With either of the above settings, the **bag_key** `data bag` will be passed in the requests to all methods of the `\Ns\App\FirstClass` class, and in the requests to the `doThat()` method of the `\Ns\App\SecondClass` class.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
        return $this->response;
    }
}
```

### Annotation

`Data bags` can also be configured using [the `@databag` annotation](../../06.annotations/03.databags/).

If the annotation is defined on a Jaxon class, then all its methods will receive the `data bag`.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

/**
 * @databag bag_key
 */
class FirstClass extends CallableClass
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
        return $this->response;
    }
}
```

If the annotation is defined on some methods, then only these methods will receive the `data bag`.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
{
    /**
     * @databag bag_key
     */
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
        return $this->response;
    }
}
```
