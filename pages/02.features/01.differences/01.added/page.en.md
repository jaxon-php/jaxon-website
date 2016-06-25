---
title: New features
menu: New features
template: jaxon
---

##### Extensibility and Modularity

The Jaxon library is modular and composed of a pure javascript package and several PHP packages.
The javascript package [jaxon-js](https://github.com/jaxon-php/jaxon-js) contains the code that manages requests and responses in the browser.
The PHP package [jaxon-core](https://github.com/jaxon-php/jaxon-core) contains the code that manages requests and responses on the server.
These two packages are required to run a Jaxon application. They can be supplemented by many other plugins that add functionality to the Jaxon library, or allow it to easily integrate with PHP frameworks.

The Jaxon javascript library files are installed on a public server, which supports the `http` and `https` protocols. By default, the PHP library loads the javascript files from this server. It is possible to install them on a private server, in which case you must update the link with the configuration option `js.lib.uri`.

##### Namespaces and Composer

All PHP packages composing the Jaxon library are namespaced, install with `Composer`, and use the `PSR-4` autoloading. The namespace of the [jaxon-core](https://github.com/jaxon-php/jaxon-core) package is `Jaxon`.
The installation and use of the library are much simpler.

##### Exporting directories

Regarding the library functions, the most important new feature is the ability to export in a few lines and recursively all the classes in a directory, possibly with a namespace.
The naming of generated javascript classes respects the hierarchy of directories, and takes into account the associated namespace when there is one.
```php
$jaxon->addClassDir($path, $namespace);
$jaxon->registerClasses();
```

##### Optimized processing

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
    // When processing the request, the requested class is automatically loaded with the autoloading.
    $jaxon->processRequest();
}
```

##### Configuration files

The Jaxon library can load its configuration settings from a file. Supported formats are JSON, YAML and PHP (the file contains code that returns an array).
```php
\Jaxon\Config\Yaml::read($yamlFilePath);    // Read configuration in a YAML file.
\Jaxon\Config\Json::read($jsonFilePath);    // Read configuration in a JSON file.
\Jaxon\Config\Php::read($phpFilePath);      // Read configuration in a PHP file.
```

##### Pagination

Finally, Jaxon library provides a pagination feature, which allows to simply create a list of links that call the same Jaxon function, but with a different page number.
```php
$itemsTotal = 45;
$itemsPerPage = 10;
$currentPage = 1;
$pagination = jr::paginate($itemsTotal, $itemsPerPage, $currentPage, 'MyClass.showPage', jr::page(), jr::html('pagination-text'));
echo $pagination;
```
