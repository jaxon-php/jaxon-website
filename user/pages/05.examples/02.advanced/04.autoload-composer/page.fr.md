---
title: Utiliser l'autoloader de Composer
menu: Autoloader de Composer
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation de l'autoloader de Composer.

Par défaut, la librairie Jaxon implémente un mécanisme simple d'autoloading où le fichier correspondant à une classe est inclus avec la fonction `require_once`.
Lorsque l'autoloader de Composer est utilisé, la librairie Jaxon enregistre tous les répertoires qui ont un namespace avec l'autoloader `PSR-4`, et tous les répertoires sans namespace avec l'autoloader `classmap`.

#### Comment ça marche

Inclure le fichier `autoload.php` de Composer, et appeler la fonction `$jaxon->useComposerAutoloader()`.
Exporter les classes dans les namespaces [définis ici](/examples/codes/namespace.html) avec Jaxon.

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
