---
title: Data bags
menu: Data bags
template: jaxon
---

`Data bags` are data sets that are stored on client side, and made available on demand in Jaxon classes.
They are convenient for data that must be available allover the application, but are only used by a few components.

Each `data bag` has an identifier which must be unique throughout the application, and each of its data is stored under a key which must be unique throughout the `data bag`.

To be able to read data from a `data bag` in a method of a Jaxon class, it must explicitly requested that its content is sent in requests to this method.

This is done either with attributes or annotations in the class, or when registering the class in [the configuration file](../../about/configuration.html), or [with calls to the jaxon()->register() function](../../registrations/namespaces.html).

#### Note on security

Since the data in `data bags` are stored in the browser, they are accessible to users. Therefore, sensitive data should not be stored in them.
Likewise, they should store as little data as possible, as this increases the size of Jaxon requests.

#### The databag attribute

The `Jaxon\Attributes\Attribute\Databag` attribute is defined on a class or method to configure `data bags`.
It takes its unique identifier as a parameter, and can be repeated to define multiple `data bags`.

If the attribute is defined on a Jaxon class, then all its methods will receive the contents of the `data bag`.

```php
namespace Ns\App;

use Jaxon\Attributes\Attribute\Databag;

#[Databag('bag_key')]
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

If the attribute is defined on a method, then only that method will receive the contents of the `data bag`.

```php
namespace Ns\App;

use Jaxon\Attributes\Attribute\Databag;

class SecondClass extends \Jaxon\App\FuncComponent
{
    #[Databag('bag_key')]
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

#### The databag annotation

The `@databag` annotation is defined on a class or method to configure `data bags`.
It takes its unique identifier as a parameter, and can be repeated to define multiple `data bags`.

If the annotation is defined on a Jaxon class, then all its methods will receive the contents of the `data bag`.

```php
namespace Ns\App;

/**
 * @databag bag_key
 */
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

If the annotation is defined on a method, then only that method will receive the contents of the `data bag`.

```php
namespace Ns\App;

class SecondClass extends \Jaxon\App\FuncComponent
{
    /**
     * @databag bag_key
     */
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

#### Configuration

With the configurations below, the `data bag` **bag_key** will be passed in requests to all methods of the `\Ns\App\FirstClass` class, and in requests to the `doThat()` method of the `\Ns\App\SecondClass` class.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
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
            '/the/class/dir' => [
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

```php
namespace Ns\App;

class SecondClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

#### Access to `data bags`

All Jaxon component classes have a `bag()` function that takes an identifier as a parameter and returns the corresponding `data bag` object.
The `data bag` object has two functions `set()` and `get()` which allow to respectively set or read a value in the `data bag`.

```php
/**
 * @databag bag_key
 */
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function save()
    {
        // The value is saved in the browser.
        $this->bag('bag_key')->set('value_key', $value);
    }

    public function read()
    {
        // The value is sent from the browser to the application.
        $value = $this->bag('bag_key')->get('value_key');
    }
}
```

#### Javascript functions

The Javascript library provides functions to read or change the values in `databags`.
These functions can be use for example to pass some parts of a `databag` content as parameter to a function call.

The `jaxon.bag.getEntry(sBagName, sBagKey)` and `jaxon.bag.setEntry(sBagName, sBagKey, xValue)` functions read or set the contents of an entry in the `databag`.

The `jaxon.bag.getValue(sBagName, sBagKey, sDataKey, xDefault)` and `jaxon.bag.setValue(sBagName, sBagKey, sDataKey, xValue)` functions read or set a value in the contents of an entry in the `databag`.
The entry's contents must be a Javascript object, and the presence of dots in the value of the `sDataKey` parameter provides access to values ​​nested within that content.
