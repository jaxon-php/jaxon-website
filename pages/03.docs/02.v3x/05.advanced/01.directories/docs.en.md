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
$jaxon = jaxon();
$jaxon->addClassDir('/the/class/dir');
$jaxon->registerClasses();
```

To determine the name of the javascript class to create, Jaxon introduced the concept of `classpath`.  
For a class registerer from a given directory, the `classpath` is the path from this directory to the subdirectory containing the class, with all `/` and `\` are replaced with `.`.  
The `classpath` is prefixed to the name of the PHP class to give the name of the corresponding javascript class.

In the above example, the javascript classes will be named `App.FirstClass` and  `App.SecondClass`.

#### Setting options on Jaxon requests

Additional options can be passed to classes when they are registered, and included in generated javascript functions.
To do this, an array must be passed to the `$jaxon->registerClasses()` call, in which each entry defines the options of a class.

Entries are indexed by the names of the javascript classes, which in this case is the name of the corresponding PHP class, prefixed with its `classpath`.

```php
$jaxon->registerClasses([
    'App.FirstClass' => [
        '*' => [
            'mode' => "'asynchronous'"
        ]
    ],
    'App.SecondClass' => [
        '*' => [
            'mode' => "'synchronous'"
        ]
    ]
]);
```

Here's the generated javascript code.

```js
App = {};
App.FirstClass = {};
App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'App.FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'asynchronous' }
    );
};
App.SecondClass = {};
App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'App.SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'synchronous' }
    );
};
```
