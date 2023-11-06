---
title: Registering directories
menu: Directories
template: jaxon
---

An average PHP application can contain dozens or even hundreds of classes. Registering individually each class with Jaxon can be tedious and error-prone, in addition to producing a verbose code.

The classes of a PHP applications will generally be distributed into separated directories, each optionally associated with a namespace.
The Jaxon library then allows the developer to register all the classes in a directory in one shot.

Consider a directory `/the/class/dir` that contains the following classes.

In file `/the/class/dir/App/FirstClass.php`

```php
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
class SecondClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

All the classes in the directory are registered with Jaxon as follow.

```php
use function Jaxon\jaxon;

$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir');
```

Without a namespace, the javascript class will have the same name as the PHP class.
In the above example, the javascript classes will be named `FirstClass` and  `SecondClass`.

Here's the generated javascript code.

```js
FirstClass = {};
FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
SecondClass = {};
SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
```

#### Setting options on Jaxon requests

Additional options can be passed to classes when they are registered, and included in generated javascript functions.
To do this, an array must be passed to the `$jaxon->register()` call, in which each entry defines the options of a class.

Entries are indexed by the names of the javascript classes, which in this case is the name of the corresponding PHP class.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'classes' => [
        'FirstClass' => [
            'functions' => [
                '*' => [
                    'mode' => "'asynchronous'"
                ]
            ]
        ],
        'SecondClass' => [
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
App = {};
FirstClass = {};
FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'asynchronous' }
    );
};
SecondClass = {};
SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'synchronous' }
    );
};
```
