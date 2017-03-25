---
title: Using the Composer Autoloader
menu: Composer Autoloader
template: jaxon
cache_enable: false
---

This example illustrates the use of the Composer autoloader.

By default, the Jaxon library implements a simple autoloading mechanism by `require_once`'ing the corresponding PHP file for each missing class.
When provided with the Composer autoloader, the Jaxon library registers all directories with a namespace into the `PSR-4` autoloader, and it registers all the classes in directories with no namespace into the `classmap` autoloader.

The classes which are registered in this example are the same as in the [Register Namespaces](../namespaces) example.

#### How it works

Include the Composer `autoload.php` file, and call the `$jaxon->useComposerAutoloader()` function

```php
require(__DIR__ . '/vendor/autoload.php');

$jaxon = jaxon();

// Use the Composer autoloader
$jaxon->useComposerAutoloader();

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
