---
title: Migrating from Xajax to Jaxon
menu: Migration
template: docs
---

Although this new version of the Jaxon library has undergone many changes, the `Response` class, which is involved in most of the code written in a Jaxon application, has not changed. This makes the migration of existing applications easier.

Here are the steps to move from a previous version to version 1.0.0 of Jaxon.

1. Make sure that the application does not use one of the classes that were deprecated.
2. Install the `jaxon-core` package with `Composer` and load the autoloader in the application.
3. Access to the main object by a call to the singleton `$jaxon = Jaxon::getInstance()`, and get response objects by instanciating the `Jaxon\Response\Response` class.
4. Set the new configuration options with calls to `$jaxon->setOption()`.
5. Insert javascript and CSS code in the HTML page with calls to `$jaxon->getCss()`, `$jaxon->getJs()` and `$jaxon->getScript()`.  

These steps are sufficient to execute an existing application with the new version of the library.
To take full advantage of the new features, the following optional steps can be performed.

* Group configuration options of Jaxon library in a configuration file, and load it.
* Move Jaxon application classes in a directory, give them a namespace, and export the directory contents.
* Use one or more plugins, installing them with `Composer`.
* Install the javascript library files on a private server, and update the link with the `js.lib.uri` configuration option.
