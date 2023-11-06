---
title: Using a Third Party Autoloader
menu: Third Party Autoloader
template: jaxon
cache_enable: false
---

In this example the autoloading is disabled in the Jaxon library, and a third-party autoloader is used to load the Jaxon classes.

The directories registered with Jaxon are also registered with the autoloader. The one used here is [Keradus](https://github.com/keradus/Psr4Autoloader).

#### How it works

Disable autoloading in the Jaxon library, and declare namespaces with the autoloader.
Register the classes in the namespaces [defined here](/examples/codes/namespace.html) with Jaxon.

```php
$jaxon = jaxon();

// Disable autoload
$jaxon->disableAutoload();

// Register the namespaces with a third-party autoloader
$loader = new Keradus\Psr4Autoloader;
$loader->register();
$loader->addNamespace('App', '/jaxon/class/dir/app');
$loader->addNamespace('Ext', '/jaxon/class/dir/ext');

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
