---
title: JQuery API
menu: JQuery API
template: jaxon
---

#### Exporting directories

The most important new feature in Jaxon is the ability to export in a few lines and recursively all the [classes in a directory](../../../docs/advanced/directories), possibly with a namespace.
The naming of generated javascript classes respects the hierarchy of directories, and takes into account the associated namespace when there is one.
```php
$jaxon->addClassDir($path1, $namespace1);
$jaxon->addClassDir($path2, $namespace2);
$jaxon->registerClasses();
```

#### Optimized processing

By default, all the classes registered with the Jaxon library are instanciated when processing a request.
When classes are exported from a directory, the jaxon library can be optimized in this case to load only the class that was called.
This is possible because Jaxon supports autoloading on classes that are exported from directories.
```php
if(!$jaxon->canProcessRequest())
{
    // When the page loads, all classes are exported, so that the code can be generated.
    $jaxon->registerClasses();
}
else
{
    // When processing a request, the requested class is autoloaded.
    $jaxon->processRequest();
}
```

#### Configuration files

The Jaxon library can load its [configuration settings](../../../docs/usage/configuration) from a file. Supported formats are JSON, YAML and PHP (the file contains code that returns an array).
```php
$jaxon->readPhpConfigFile($yamlFilePath);   // Read configuration in a PHP file.
$jaxon->readYamlConfigFile($jsonFilePath);  // Read configuration in a YAML file.
$jaxon->readJsonConfigFile($phpFilePath);   // Read configuration in a JSON file.
$jaxon->readConfigFile($phpFilePath);       // Read configuration in a file based on its extension.
```

#### Pagination

Finally, Jaxon library provides a [pagination feature](../../../docs/advanced/pagination), which allows to simply create a list of links that call the same Jaxon function, but with a different page number.
```php
$itemsTotal = 45;
$itemsPerPage = 10;
$currentPage = 1;
$pagination = jr::paginate($itemsTotal, $itemsPerPage, $currentPage, 'MyClass.showPage', jr::page(), jr::html('pagination-text'));
echo $pagination;
```
