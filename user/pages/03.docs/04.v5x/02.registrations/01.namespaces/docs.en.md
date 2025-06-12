---
title: Registering directories with namespaces
menu: Namespaces
template: jaxon
---

The simplest way to register classes with Jaxon is to provide a directory and an associated namespace.
All the classes in the directory are registered, and the corresponding javascript classes are named upong the the full PHP class names.

Consider a directory `/the/class/dir` associated to the namespace `Ns` and containing the following classes.

In file `/the/class/dir/App/FirstClass.php`

```php
namespace Ns\App;

class FirstClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

In file `/the/class/dir/App/SecondClass.php`

```php
namespace Ns\App;

class SecondClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

#### Declare the namespaces

The `app.directories` section of the configuration contains an array of directories where the classes to be registered are found.
Each entry of the array represents a directory, defined with its full path and the following informations:

- `path`: mandatory, the path to the directory.
- `namespace`: optional, the associated namespace.
- `autoload`: optional, boolean, if true (default), the directory is registered with the autoloaded.
- `separator`: optional, the separator to be used in javascript class names, can be `.` (by default) or `_`.
- `protected`: optional, an array of methods that are not to be exported in javascript classes, empty by default.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
            ]
        ]
    ]
```

Namespaces can also be registered with calls to the library functions.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['namespace' => 'Ns']);
```

The generated javascript objects will be named `Ns.App.FirstClass` and  `Ns.App.SecondClass`, with the methods `Ns.App.FirstClass.myMethod()` and  `Ns.App.SecondClass.myMethod()`, which will send Ajax request to the corresponding PHP methods.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
```

#### Adding options to classes

Additional options can be passed to classes when they are registered, and included in generated javascript functions.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'functions' => [
                            '*' => [
                                'mode' => "'asynchronous'",
                            ]
                        ]
                    ],
                    \Ns\App\SecondClass::class => [
                        'functions' => [
                            '*' => [
                                'mode' => "'synchronous'"
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
            'functions' => [
                '*' => [
                    'mode' => "'asynchronous'"
                ]
            ]
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                '*' => [
                    'mode' => "'synchronous'"
                ]
            ]
        ]
    ]
]);
```

Entries are indexed by the names of the javascript classes, which in this case is the full name of the corresponding PHP class, with its namespace.

Here's the generated javascript code.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'asynchronous' }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'synchronous' }
    );
};
```

#### Autoloading a namespace

When registering a directory with a namespace, the `autoload` option can be used to setup autoloading.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['namespace' => 'Ns', 'autoload' => true]);
```
