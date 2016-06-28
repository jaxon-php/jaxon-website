---
title: Using a Third Party Autoloader
menu: Third Party Autoloader
template: jaxon
cache_enable: false
description: In this example the autoloading is disabled in the Jaxon library, and a third-party autoloader is used to load the Jaxon classes.
---

<div class="row" markdown="1">
The directories registered with Jaxon are also registered with the autoloader. The one used here is [Keradus](https://github.com/keradus/Psr4Autoloader).
</div>

<div class="row" markdown="1">
The classes which are registered in this example are the same as in the [Register Namespaces](../namespaces) example.
</div>

<div class="row">
    <h5>How it works</h5>

<p>Disable autoloading in the Jaxon library, and declare namespaces with the autoloader</p>

<pre><code class="language-php">
$jaxon = Jaxon::getInstance();

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
</code></pre>

</div>
