---
title: Migrating from Xajax to Jaxon
menu: Migration from Xajax
template: jaxon
---

Although the Jaxon library has undergone many changes, the `Response` class, which is involved in most of the code written in a Jaxon application, has not changed. This makes the migration of existing applications easier.

Here are the steps to migrate from a previous version of Xajax to Jaxon.

1. Make sure that the application does not use one of the classes that were deprecated.
2. Install the `jaxon-core` package with `Composer` and load the autoloader in the application.
3. Access to the main object with `$jaxon = jaxon()`, and get response objects by instanciating the `Jaxon\Response\Response` class.
4. Set the new configuration options with calls to `$jaxon->setOption()`, especially the `core.request.uri` and `core.language` options which replace the `$sRequestURI` and `$sLanguage` parameters of the `xajax` class constructor.
5. Insert javascript and CSS code in the HTML page with calls to `$jaxon->getCss()`, `$jaxon->getJs()` and `$jaxon->getScript()`.  

These steps are sufficient to execute an existing application with the new version of the library.
To take full advantage of the new features, the following optional steps can be performed.

* Group configuration options of Jaxon library in a configuration file, and load it.
* Move Jaxon application classes in a directory, give them a namespace, and export the directory contents.
* Use one or more plugins, installing them with `Composer`.
* Load the javascript library files from the [jsDelivr CDN](https://www.jsdelivr.com/projects/jaxon).

Read the [New features](../../../features/what_new/features), [Evolved features](../../../features/differences/changed) and [Deprecated features](../../../features/differences/deprecated) pages to learn more about the differences between Xajax and Jaxon.

The following table shows the correspondances between the old and new names of options.

| Previous | Current | Comment     |
|----------|---------|-------------|
| language                     | core.language              | |
| version                      | core.version               | |
| characterEncoding            | core.encoding              | |
| decodeUTF8Input              | core.decode_utf8           | |
| | | |
| requestURI                   | core.request.uri           | |
| defaultMode                  | core.request.mode          | |
| defaultMethod                | core.request.method        | |
| | | |
| wrapperPrefix                | core.prefix.function       | A former option is covered by two new |
| wrapperPrefix                | core.prefix.class          | A former option is covered by two new |
| eventPrefix                  | core.prefix.event          | |
| | | |
| responseType                 | **deprecated**             | The response type is always JSON |
| contentType                  | **deprecated**             | The content type is always JSON |
| outputEntities               | **deprecated**             | |
| | | |
| cleanBuffer                  | core.process.clean_buffer  | |
| exitAllowed                  | core.process.exit_after    | |
| timeout                      | core.process.timeout       | |
| | | |
| errorHandler                 | core.error.handle          | |
| logFile                      | core.error.log_file        | |
| | | |
| debug                        | core.debug.on              | |
| verboseDebug                 | core.debug.verbose         | |
| | | |
| debugOutputID                | js.lib.output_id           | |
| responseQueueSize            | js.lib.queue_size          | |
| scriptLoadTimeout            | js.lib.load_timeout        | **Supprimé dans la version 2** |
| waitCursor                   | js.lib.show_cursor         | |
| statusMessages               | js.lib.show_status         | |
| javascript URI               | js.lib.uri                 | A former option is covered by two new |
| javascript URI               | js.app.uri                 | A former option is covered by two new |
| javascript Dir               | js.app.dir                 | |
| deferDirectory               | js.app.dir                 | |
| javascript files             | **deprecated**             | |
| useUncompressedScripts       | **deprecated**             | |
| deferScriptGeneration        | js.app.extern              | A former option is covered by two new |
| deferScriptGeneration        | js.app.minify              | A former option is covered by two new |
| scriptDefferal               | js.app.options             | |
| | | |
| deferScriptValidateHash      | **deprecated**             | |
| | | |
