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
$jaxon = jaxon();
$jaxon->addClassDir('/the/class/dir', 'Ns');
$jaxon->registerClasses();
```

The generated javascript classes will be named `Ns.App.FirstClass` and  `Ns.App.SecondClass`.
The `classpath` is prefixed with the namespace of the registered directory.
