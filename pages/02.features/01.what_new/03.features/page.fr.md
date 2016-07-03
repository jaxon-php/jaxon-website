---
title: Nouvelles fonctionnalités
menu: Nouvelles fonctionnalités
template: jaxon
---

##### Export de répertoires

S'agissant des fonctions de la librairie, la nouveauté la plus importante est la possibilité d'exporter en quelques lignes et de façon récursive toutes les classes présentes dans un répertoire, éventuellement avec un namespace.
Le nommage des classes javascript générées respecte la hiérarchie des répertoires, et tient compte du namespace associé lorsqu'il y en a un.
```php
$jaxon->addClassDir($path1, $namespace1);
$jaxon->addClassDir($path2, $namespace2);
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
$jaxon->readPhpConfigFile($yamlFilePath);   // Lire la configuration dans un fichier PHP.
$jaxon->readYamlConfigFile($jsonFilePath);  // Lire la configuration dans un fichier YAML.
$jaxon->readJsonConfigFile($phpFilePath);   // Lire la configuration dans un fichier JSON.
$jaxon->readConfigFile($phpFilePath);       // Lire la configuration en fonction de l'extension du fichier.
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
