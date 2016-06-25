---
title: Export with namespaces
menu: Namespaces
template: jaxon
---

A directory which is registered with Jaxon can be associated with a namespace.

For example, if the directory `/the/class/dir` is associated to namespace `My\Ns`, it will be registered as follow.
```php
$jaxon->addClassDir('/the/class/dir', 'My\Ns');
$jaxon->registerClasses();
```

Assuming that the following class is defined in the file `/the/class/dir/My/App/MyClass.php`,
```php
namespace My\Ns\My\App;

class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}
```
The generated javascript class will be named `My.Ns.My.App.MyClass`.
