---
title: Utiliser l'autoloading pour les classes Jaxon
menu: Autoloader par défaut
template: jaxon
cache_enable: false
---

Cet exemple montre comment optimiser le traitement des requêtes Jaxon avec l'autoloading.

Dans cet exemple, les classes Jaxon ne sont pas exportées lorsqu'une requête est traitée.
Cependant, la librairie est assez intelligente pour se rendre compte que que la classe demandée est absente, et charger uniquement le fichier nécessaire.

#### Comment ça marche

Exporter les classes dans les namespaces [définis ici](/examples/codes/namespace.html) avec Jaxon.
Les classes ne sont exportées que lorsque la page est générée, et pas quand une requête est traitée.

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
