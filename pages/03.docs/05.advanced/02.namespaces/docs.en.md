---
title: Export with namespaces
menu: Namespaces
template: docs
---

An average PHP application can contain dozens or even hundreds of classes. Export individually each class with Jaxon can be tedious and error-prone, in addition to producing a verbose code.
Moreover, when the classes are namespaced, it is possible that several of them have the same name. To distinguish them in the javascript code, the namespace should be taken into account when naming the corresponding javascript class.

Classes of PHP applications will generally be installed in a few toplevel directories, and distributed into several subdirectories. Each directory can be optionally associated with a namespace. The Jaxon library allows the developer to export all the classes in a directory in a few calls, with their namespace if one exists.

The following function adds a directory to the list of those to be exported, together with its namespace. It must be called as many times as there are directories to consider.
```php
$jaxon->addClassDir($sPath, $sNamespace = null, array $aExcluded = array());
```

The following function exports all classes present in the directories registered with the previous one.
```php
$jaxon->registerClasses();
```

To determine the name of the javascript class to create, Jaxon introduced the concept of `classpath`. For a class installed in a particular subdirectory, the `classpath` is the path from the toplevel directory to the one containing the class. If there is a `namespace` associated, it is prefixed to the `classpath`. Finally, `/` and `\` are replaced with `.`, and the `classpath` is prefixed to the name of the PHP class to give the name of the javascript class.

If a directory `X` is registered without namespace, a class`C` installed in the directory `X/Y/Z` will have classpath `Y.Z`, and the name of the javascript class will be `Y.Z.C`. If the namespace `N` is associated with the directory `X`, it is prefixed to the classpath, and the name of the javascript class will be `N.Y.Z.C`.

Here are examples of how to register directories, [without namespace](http://www.jaxon-php.org/classdirs.php), and [with namespace](http://www.jaxon-php.org/namespaces.php).
