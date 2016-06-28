---
title: Utiliser un autoloader d'une tierce partie
menu: Autoloader tierce
template: jaxon
cache_enable: false
description: Dans cet exemple l'autoloading est désactivé dans la librairie Jaxon, et un autoloader d'une tierce partie est utilisé pour charger les classes Jaxon.
---

<div class="row" markdown="1">
Les répertoires exportés avec Jaxon sont également enregistrés dans l'autoloader. Celui utilisé ici est [Keradus](https://github.com/keradus/Psr4Autoloader).
</div>

<div class="row" markdown="1">
Les classes exportées dans cet exemple sont les mêmes que celles de l'exemple [Exporter des namespaces](../namespaces).
</div>

<div class="row">
    <h5>Comment ça marche</h5>

<p>1. Désactiver l'autoloading dans la librairie Jaxon, et déclarer les namespaces dans l'autoloader</p>

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
