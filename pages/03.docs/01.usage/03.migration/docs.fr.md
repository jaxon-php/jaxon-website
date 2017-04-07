---
title: Migrer de Xajax vers Jaxon
menu: Migration de Xajax
template: jaxon
---

Bien que la librairie Jaxon ait subi de nombreux changements, la classe `Response`, qui intervient dans la plus grande partie du code écrit dans une application Jaxon, n'a pas été modifiée. Ceci va rendre plus simple la migration des applications existantes.

Voici les étapes à suivre pour passer d'une version précédente de Xajax à Jaxon.

1. Vérifier que l'application n'utilise pas l'une des classes qui ont été supprimées.
2. Installer le package `jaxon-core` avec `Composer`, et charger son autoloader dans l'application.
3. Accéder à l'objet principal avec `$jaxon = jaxon()`, et pour les réponses instancier la classe `Jaxon\Response\Response`.
4. Définir les nouvelles options de configuration avec la fonction `$jaxon->setOption()`, en particulier les options `core.request.uri` et `core.language` qui remplacent les paramètres `$sRequestURI` et `$sLanguage` du constructeur de la classe `xajax`.
5. Afficher le code javascript et CSS dans la page HTML avec les appels aux fonctions `$jaxon->getCss()`, `$jaxon->getJs()` et `$jaxon->getScript()`.  

Ces étapes sont suffisantes pour éxécuter une application existante avec la nouvelle version de la librairie.
Pour tirer pleinement parti des nouveautés, les étapes optionnelles suivantes peuvent être appliquées.

* Regrouper les options de configuration de la librairie Jaxon dans un fichier de configuration, et charger celui-ci.
* Regrouper les classes Jaxon de l'application dans un répertoire, leur associer un namespace, et exporter le contenu du répertoire.
* Utiliser un ou plusieurs plugins, en les installant avec `Composer`.
* Charger les fichiers javascript à partir du [CDN jsDelivr](https://www.jsdelivr.com/projects/jaxon).

Consulter les pages [New features](../../../features/what_new/features), [Evolved features](../../../features/differences/changed) et [Deprecated features](../../../features/differences/deprecated) pour en savoir plus sur les différences entre Xajax et Jaxon.

Le tableau suivant donne les correspondances etre les anciens et les nouveaux noms des options.

| Ancien | Nouveau | Commentaire |
|--------|---------|-------------|
| language                     | core.language              | |
| version                      | core.version               | |
| characterEncoding            | core.encoding              | |
| decodeUTF8Input              | core.decode_utf8           | |
| | | |
| requestURI                   | core.request.uri           | |
| defaultMode                  | core.request.mode          | |
| defaultMethod                | core.request.method        | |
| | | |
| wrapperPrefix                | core.prefix.function       | Un ancien paramètre correspond à deux nouveaux |
| wrapperPrefix                | core.prefix.class          | Un ancien paramètre correspond à deux nouveaux |
| eventPrefix                  | core.prefix.event          | |
| | | |
| responseType                 | **deprecated**             | Le type de réponse est toujours JSON |
| contentType                  | **deprecated**             | Le type de contenu est toujours JSON |
| outputEntities               | **deprecated**             | |
| | | |
| cleanBuffer                  | core.process.clean_buffer  | |
| exitAllowed                  | core.process.exit_after    | |
| timeout                      | core.process.timeout       | |
| | | |
| errorHandler                 | core.error.handle          | |
| logFile                      | core.error.log_file        | |
| | | |
| debug                        | core.debug.on            | |
| verboseDebug                 | core.debug.verbose       | |
| | | |
| debugOutputID                | js.lib.output_id         | |
| responseQueueSize            | js.lib.queue_size        | |
| scriptLoadTimeout            | js.lib.load_timeout      | **removed in version 2** |
| waitCursor                   | js.lib.show_cursor       | |
| statusMessages               | js.lib.show_status       | |
| javascript URI               | js.lib.uri               | Un ancien paramètre correspond à deux nouveaux |
| javascript URI               | js.app.uri               | Un ancien paramètre correspond à deux nouveaux |
| javascript Dir               | js.app.dir               | |
| deferDirectory               | js.app.dir               | |
| javascript files             | **deprecated**           | |
| useUncompressedScripts       | **deprecated**           | |
| deferScriptGeneration        | js.app.extern            | Un ancien paramètre correspond à deux nouveaux |
| deferScriptGeneration        | js.app.minify            | Un ancien paramètre correspond à deux nouveaux |
| scriptDefferal               | js.app.options           | |
| | | |
| deferScriptValidateHash      | **deprecated**           | |
| | | |
