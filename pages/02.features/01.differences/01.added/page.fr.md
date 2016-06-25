---
title: Nouvelles fonctionnalités
menu: Nouvelles fonctionnalités
template: jaxon
---

##### Extensibilité et modularité

La librairie Jaxon est modulaire, et composée d'un package javascript pur et de plusieurs packages PHP.
Le package javascript [jaxon-js](https://github.com/jaxon-php/jaxon-js) contient le code qui gère les requêtes et les réponses dans le navigateur.
Le package PHP [jaxon-core](https://github.com/jaxon-php/jaxon-core) contient le code qui gère les requêtes et les réponses sur le serveur.
Ces deux packages sont requis pour exécuter une application Jaxon. Ils peuvent être complétés par de nombreux autres plugins qui ajoutent des fonctionnalités à la librairie Jaxon, ou lui permettent de s'intégrer aisément à des frameworks PHP.

Les fichiers de la librairie javascript Jaxon sont installés sur un serveur public, qui supporte les protocoles `http` et `https`. Par défaut, la librairie PHP les charge à partir de ce serveur. Il est cependant possible de les installer sur un serveur privé, auquel cas il faut mettre à jour le lien avec l'option de configuration `js.lib.uri`.

##### Namespaces et Composer

Tous les packages PHP de la librairie Jaxon sont namespacés, s'installent avec `Composer`, et utilisent l'autoloading `PSR-4`. Le namespace du package [jaxon-core](https://github.com/jaxon-php/jaxon-core) est `Jaxon`. L'installation et l'utilisation de la librairie sont donc beaucoup plus simples.

##### Export de répertoires

S'agissant des fonctions de la librairie, la nouveauté la plus importante est la possibilité d'exporter en quelques lignes et de façon récursive toutes les classes présentes dans un répertoire, éventuellement avec un namespace. Le nommage des classes javascript générées respecte la hiérarchie des répertoires, et tient compte du namespace associé lorsqu'il y en a un.
```php
$jaxon->addClassDir($path, $namespace);
$jaxon->registerClasses();
```

##### Optimisation du traitement

Par défaut, toutes les classes exportées avec la librairie Jaxon sont instanciées lorsqu'une requête est traitée.
Lorsque des classes sont exportées à partir d'un répertoire, la librairie Jaxon peut être optimisée pour ne charger que la classe qui a été appelée.
Cela est possible parce que Jaxon supporte l'autoloading sur les classes exportées d'un répertoire.
```php
if(!$jaxon->canProcessRequest())
{
    // Lors du chargement de la page, toutes les classes sont exportées, pour que le code puisse être généré.
    $jaxon->registerClasses();
}
else
{
    // Lors du traitement de la requête, la classe demandée est automatiquement chargée, avec l'autoloading.
    $jaxon->processRequest();
}
```

##### Fichiers de configuration

La librairie Jaxon peut charger ses paramètres de configuration à partir d'un fichier. Les formats supportés sont JSON, YAML et PHP (le fichier contient du code qui retourne un tableau).
```php
\Jaxon\Config\Yaml::read($yamlFilePath);    // Lire la configuration dans un fichier YAML.
\Jaxon\Config\Json::read($jsonFilePath);    // Lire la configuration dans un fichier JSON.
\Jaxon\Config\Php::read($phpFilePath);      // Lire la configuration dans un fichier PHP.
```

##### Pagination

Enfin, la librairie Jaxon fournit une fonction de pagination, qui permet de créer simplement une liste de liens qui appellent une même fonction Jaxon, mais avec un numéro de page qui s'incrémente.
```php
$itemsTotal = 45;
$itemsPerPage = 10;
$currentPage = 1;
$pagination = jr::paginate($itemsTotal, $itemsPerPage, $currentPage, 'MyClass.showPage', jr::page(), jr::html('pagination-text'));
echo $pagination;
```
