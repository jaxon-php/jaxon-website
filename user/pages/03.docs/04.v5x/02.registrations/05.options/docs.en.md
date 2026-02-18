---
title: Setting options
menu: Options
template: jaxon
---

Jaxon allows the developer to set options on namespaces, classes and functions registrations.

Those options can apply to PHP code, Javascript code, or both.

### PHP options

When they apply to PHP code, the options are added to classes and functions metadata.
They will be taken into account during their processing.

It is the case for example for [class callbacks](../../requests/php-callbacks.html), and [upload](../../features/upload.html).

### Javascript options

When they apply to Javascript code, the options are added to the parameters of the Ajax requests to classes and functions.

It is the case for example for [Javascript callbacks](../../requests/js-callbacks.html), and [upload](../../features/upload.html).

### The `excluded` option

The `excluded` option is different, as it will instead indicate that a PHP class or public method should not be exported to Javascript.

In the configuration file.

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

With attributes.

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
use Jaxon\Attributes\Attribute\Exclude;

// This class will not be exported to javascript.
#[Exclude]
class FirstClass
{
}
```

```php
use Jaxon\Attributes\Attribute\Exclude;

class SecondClass
{
    #[Exclude]
    public function doThat()
    {
        // This method will not be exported to javascript.
    }
}
```

```php
use Jaxon\Attributes\Attribute\Exclude;

class SecondClass
{
    #[Exclude(true)]
    public function doThat()
    {
        // This method will not be exported to javascript.
    }

    #[Exclude(false)]
    public function doThis()
    {
        // This method will be exported to javascript.
    }
}
```

With annotations.

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

### The `export` option

The `export` option defines in a Jaxon component in a little more detail the methods that should be exported to Javascript.

Three values, all arrays of function names, can be defined in this option:
- base: the methods of the base classes of the components to be exported: `render`, `clear`, and `visible`.
- only: the methods of the application component classes to be exported.
- except: the methods of the application component classes not to be exported.

In the configuration file.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'export' => [
                            'base' => ['render'],
                            'only' => [],
                            'except' => [],
                        ],
                    ],
                ]
            ]
        ]
    ]
```

With attributes.

```php
use Jaxon\Attributes\Attribute\Export;
use Ns\App\FirstClass;

// The render() method will be exported to javascript.
#[Export(base: ['render'])]
class FirstClass extends \Jaxon\App\NodeComponent
{
}
```

With annotations.

```php
use Ns\App\FirstClass;

// The render() method will be exported to javascript.
/**
 * @export ["base": ["render"]]
 */
class FirstClass extends \Jaxon\App\NodeComponent
{
}
```
