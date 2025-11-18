---
title: L'autoloading
menu: L'autoloading
template: jaxon
---

Considérons le code suivant, où 3 classes sont enregistrées avec Jaxon.

```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new JaxonClass1);
$jaxon->register(Jaxon::CALLABLE_OBJECT, new JaxonClass2);
$jaxon->register(Jaxon::CALLABLE_OBJECT, new JaxonClass3);
$jaxon->processRequest(); 
```

Les 3 classes sont instanciées lors du traitement de chaque requête, alors qu'au final une seule sera utilisée.

Lorsque des classes sont enregistrées à partir d'un répertoire, l'autoloading permet lors du traitement d'une requête pour n'instancier que la classe qui a été appelée.

```php
$jaxon->addClassDir($dirA, $namespaceA);
$jaxon->addClassDir($dirB, $namespaceB);

if(!$jaxon->canProcessRequest())
{
    // Lors du chargement de la page, toutes les classes sont enregistrées, pour que le code puisse être généré.
    $jaxon->registerClasses();
}
else
{
    // Lors du traitement de la requête, la classe demandée est automatiquement chargée, avec l'autoloading.
    $jaxon->processRequest();
}
```

Lors du chargement de la page, toutes les classes Jaxon doivent être enregistrées pour que le code javascript correspondant puisse être généré.
Par contre lors du traitement d'une requête, instancier toutes les classes n'est pas nécessaire.  
Grâce à l'autoloading, seule la classe demandée par la requête sera chargée.

Par défaut, Jaxon utilise une version simple de l'autoloading où il charge les fichiers des classes avec la fonction PHP `require()`.
Mais il est également possible de lui demander d'utiliser l'autoloader de `Composer`, ou encore d'utiliser un autoloader d'une tierce-partie.

#### Utiliser l'autoloader de Composer

Pour utiliser l'autoloader de `Composer`, il faut appeler la fonction `$jaxon->useComposerAutoloader()`. A partir de ce moment, toutes les classes dans un répertoire enregistré avec un namespace seront chargées avec l'autoloader `PSR-4`, et toutes les classes dans un répertoire enregistré sans namespace seront chargées avec l'autoloader `ClassMap`.

```php
// Use Composer autoloader
$jaxon->useComposerAutoloader();
$jaxon->addClassDir($dirA, $namespaceA);
$jaxon->addClassDir($dirB, $namespaceB);
```

#### Utiliser un autre l'autoloader

Pour utiliser un autoloader d'une tierce-partie, il faut désactiver l'autoloading dans la librairie Jaxon avec un appel à la fonction `$jaxon->disableAutoload()`.
A partir de ce moment, il est de la responsabilité du développeur de mettre en place l'autoloading pour les répertoires qu'il enregistre.

L'exemple ci-dessous utilise l'autoloader de [https://github.com/keradus/Psr4Autoloader](https://github.com/keradus/Psr4Autoloader?target=_blank).

```php
// Enregistrer les namespaces avec l'autoloader
$loader = new Keradus\Psr4Autoloader;
$loader->register();
$loader->addNamespace($namespaceA, $dirA);
$loader->addNamespace($namespaceB, $dirB);

// L'autoloader est désactivé dans Jaxon
$jaxon->disableAutoload();
$jaxon->addClassDir($dirA, $namespaceA);
$jaxon->addClassDir($dirB, $namespaceB);
```
