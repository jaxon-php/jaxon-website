---
title: Registering directories with namespaces
menu: Namespaces
template: jaxon
---

If a directory is associated with a namespace, it can be specified while registering the directory with Jaxon.
The names of the javascript classes will then take this namespace into account.

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

The classes will be registered as follow.

```php
use function Jaxon\jaxon;

$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['namespace' => 'Ns']);
```

The generated javascript classes will be named `Ns.App.FirstClass` and  `Ns.App.SecondClass`.

Here's the generated javascript code.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
```

#### Setting options on Jaxon requests

Additional options can be passed to classes when they are registered, and included in generated javascript functions.
To do this, an array must be passed to the `$jaxon->register()` call, in which each entry defines the options of a class.

Entries are indexed by the names of the javascript classes, which in this case is the full name of the corresponding PHP class, with its namespace.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
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

Here's the generated javascript code.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'asynchronous' }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'synchronous' }
    );
};
```
