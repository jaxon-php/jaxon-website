---
title: Setting options
menu: Options
template: jaxon
---

Jaxon allows the developer to set options on namespaces, classes and functions registrations.

Those options can apply to PHP code, Javascript code, or both.

#### PHP options

When they apply to PHP code, the options are added to classes and functions metadata.
They will be taken into account during their processing.

It is the case for example for [class callbacks](../../features/callbacks.html), and [upload](../../features/upload.html).

#### Javascript options

When they apply to Javascript code, the options are added to the parameters of the Ajax requests to classes and functions.

It is the case for example for [Javascript callbacks](../../requests/js-callbacks.html), and [upload](../../features/upload.html).

#### The `excluded` option

The `excluded` option is different, as it will instead indicate that a PHP class or public method should not be exported to Javascript.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'excluded' => true,
                    ],
                    \Ns\App\SecondClass::class => [
                        'functions' => [
                            'doThat' => [
                                'excluded' => true,
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
```

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\FirstClass::class => [
            'excluded' => true,
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                'doThat' => [
                    'excluded' => true,
                ]
            ]
        ]
    ]
]);
```

```php
// This class will not be exported to javascript.
/**
 * @exclude
 */
class FirstClass
{
}
```

```php
class SecondClass
{
    /**
     * @exclude
     */
    public function doThat()
    {
        // This method will not be exported to javascript.
    }
}
```

```php
class SecondClass
{
    /**
     * @exclude true
     */
    public function doThat()
    {
        // This method will not be exported to javascript.
    }

    /**
     * @exclude false
     */
    public function doThis()
    {
        // This method will be exported to javascript.
    }
}
```
