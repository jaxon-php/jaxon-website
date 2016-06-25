---
title: Exporting directories
menu: Directories
template: jaxon
---

An average PHP application can contain dozens or even hundreds of classes. Exporting individually each class with Jaxon can be tedious and error-prone, in addition to producing a verbose code.

Classes of PHP applications will generally be distributed into few directories, each optionally associated with a namespace.
The Jaxon library then allows the developer to export all the classes in a directory in one shot.

For example, consider a directory `/the/class/dir` that contains several classes including, in file `/the/class/dir/My/App/MyClass.php`
```php
class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

All the classes in the directory are registered with Jaxon as follow.
```php
$jaxon->addClassDir('/the/class/dir');
$jaxon->registerClasses();
```

To determine the name of the javascript class to create, Jaxon introduced the concept of `classpath`.  
For a class registerer from a given directory, the `classpath` is the path from this directory to the subdirectory containing the class, with all `/` and `\` are replaced with `.`.  
The `classpath` is prefixed to the name of the PHP class to give the name of the javascript class.

In the above example, the javascript class will be named `My.App.MyClass`.
