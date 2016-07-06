---
title: Autoloading
menu: Autoloading
template: jaxon
---

Let's consider the following code, where 3 classes are registered with Jaxon.
```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new JaxonClass1);
$jaxon->register(Jaxon::CALLABLE_OBJECT, new JaxonClass2);
$jaxon->register(Jaxon::CALLABLE_OBJECT, new JaxonClass3);
$jaxon->processRequest(); 
```
The 3 classes are instanciated each time a request is processed, even though only one will actually be used.

When classes are registered from a directory, autoloading allows when processing a request to load only the class that was called.
```php
$jaxon->addClassDir($dirA, $namespaceA);
$jaxon->addClassDir($dirB, $namespaceB);

if(!$jaxon->canProcessRequest())
{
    // When loading the page, all classes are loaded so the code can be generated.
    $jaxon->registerClasses();
}
else
{
    // When processing a request, the class that was called is autoloaded. 
    $jaxon->processRequest();
}
```
When the page loads, all Jaxon classes must be registered so the corresponding javascript code can be generated. But when processing a query, loading all classes is not necessary.  
With autoloading, only the class requested by the query will be loaded.

By default, Jaxon uses a simple implementation of the autoloading where class files are loaded with the `require()` PHP function.
But it is also possible to make Jaxon use the `Composer` autoloader, or to use an autoloader from a third party.

##### Using Composer autoloader

A call to `$jaxon->useComposerAutoloader()` makes the Jaxon library use the `Composer` autoloader. From that moment, all the classes in a directory registered with a namespace will be loaded with the `PSR-4` autoloader, while all classes in a directory registered without namespace will be loaded with the `ClassMap` autoloader.
```php
// Use Composer autoloader
$jaxon->useComposerAutoloader();
$jaxon->addClassDir($dirA, $namespaceA);
$jaxon->addClassDir($dirB, $namespaceB);
```

##### Using a third party autoloader

To use an autoloader from a third-party, autoloading must be disabled in the Jaxon library, by calling `$jaxon->disableAutoload()`.
From that moment, it is the responsibility of the developer to implement autoloading for the directories he registers.

The example below uses the autoloader from [https://github.com/keradus/Psr4Autoloader](https://github.com/keradus/Psr4Autoloader?target=_blank).
```php
// Register the namespaces with the autoloader
$loader = new Keradus\Psr4Autoloader;
$loader->register();
$loader->addNamespace($namespaceA, $dirA);
$loader->addNamespace($namespaceB, $dirB);

// The autoloader is disabled in Jaxon
$jaxon->disableAutoload();
$jaxon->addClassDir($dirA, $namespaceA);
$jaxon->addClassDir($dirB, $namespaceB);
```
