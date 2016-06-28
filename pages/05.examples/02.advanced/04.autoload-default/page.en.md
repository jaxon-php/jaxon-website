---
title: Using Autoloading for Jaxon classes
menu: Default Autoloader
template: jaxon
cache_enable: false
description: This example shows how to optimize Jaxon requests processing with autoloading.
---

<div class="row">
In this example, the Jaxon classes are not registered when processing a request.
However, the Jaxon library is smart enough to detect that the required class is missing, and to load only the necessary file.
</div>

<div class="row" markdown="1">
The classes which are registered in this example are the same as in the [Register Namespaces](../namespaces) example.
</div>

<div class="row">
    <h5>How it works</h5>

<p>1. The classes are registered only when the page is generated, and not when a request is processed</p>

<pre><code class="language-php">
$jaxon = Jaxon::getInstance();

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
