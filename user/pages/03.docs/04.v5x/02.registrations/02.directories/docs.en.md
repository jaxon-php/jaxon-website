---
title: Registering directories
menu: Directories
template: jaxon
---

Although this is not recommended, it is also possible to declare classes in directories without a namespace.
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

#### Declare the namespaces

The classes in the directory are registered with Jaxon as follow.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                // 'autoload' => true,
                // 'protected' => [],
            ]
        ]
    ]
```

Directories can also be registered with calls to the library functions.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir');
```

Without a namespace, the javascript class will have the same name as the PHP class.
In the above example, the javascript classes will be named `FirstClass` and  `SecondClass`.

Here's the generated javascript code.

```js
FirstClass = {};
FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
SecondClass = {};
SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
```

#### Setting options

Additional options can be passed to classes when they are registered, and included in generated javascript functions.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                // 'autoload' => true,
                // 'protected' => [],
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
            ]
        ]
    ]
```

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
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
FirstClass = {};
FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'asynchronous' }
    );
};
SecondClass = {};
SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'synchronous' }
    );
};
```

#### Autoloading a directory

When registering a directory without a namespace, the `autoload` option can be use to setup autoloading.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['autoload' => true]);
```
