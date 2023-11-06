---
title: Using Autoloading for Jaxon classes
menu: Default Autoloader
template: jaxon
cache_enable: false
---

This example shows how to optimize Jaxon requests processing with autoloading.

In this example, the Jaxon classes are not registered when processing a request.
However, the Jaxon library is smart enough to detect that the required class is missing, and to load only the necessary file.

#### How it works

Register the classes in the namespaces [defined here](/examples/codes/namespace.html) with Jaxon.
The classes are registered only when the page is generated, and not when a request is processed.

```php
$jaxon = jaxon();

// Add class dirs with namespaces
$jaxon->addClassDir('/jaxon/class/dir/app', 'App');
$jaxon->addClassDir('/jaxon/class/dir/ext', 'Ext');

// Check if there is a request.
if($jaxon->canProcessRequest())
{
    // When processing a request, the required class will be autoloaded
    $jaxon->processRequest();
}
else
{
    // The Jaxon objects are registered only when the page is generated
    $jaxon->registerClasses();
}
```
