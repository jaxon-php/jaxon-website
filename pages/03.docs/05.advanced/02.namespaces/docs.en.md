---
title: Export with namespaces
menu: Namespaces
template: jaxon
---

A directory which is registered with Jaxon can be associated with a namespace.

Consider a directory `/the/class/dir` that is associated to namespace `Ns` and contains the following classes.

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
$jaxon->addClassDir('/the/class/dir', 'Ns');
$jaxon->registerClasses();
```

The generated javascript classes will be named `Ns.App.FirstClass` and  `Ns.App.SecondClass`.
