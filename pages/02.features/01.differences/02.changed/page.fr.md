---
title: Fonctionnalités modifiées
menu: Fonctionnalités modifiées
template: jaxon
---

##### Namespaces

Toutes les classes du package [jaxon-core](https://github.com/jaxon-php/jaxon-core) se trouvent désormais dans le namespace `Jaxon`. La classe principale est un singleton, donc l'unique instance est renvoyée par la méthode `Jaxon::getInstance()`. L'URI qui était passé au constructeur de la classe dans la version précédente doit désormais être définie avec l'option de configuration `core.request.uri`. Donc pour commencer une application Jaxon, on écrira ceci.
```php
use Jaxon\Jaxon;

$jaxon = Jaxon::getInstance();
$jaxon->setOption('core.request.uri', $uri);
```

##### Constantes

Les constantes ont été renommées, et sont désormais toutes définies dans la classe principale `Jaxon`. Le nouveau nom des constantes est obtenu en remplaçant le préfixe `XAJAX_` par le nom de la classe `Jaxon::`, comme dans l'exemple suivant.
```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, $myObject); // Nouveau code
$jaxon->register(XAJAX_CALLABLE_OBJECT, $myObject); // Ancien code
```
Les exceptions à cette règle sont les constantes `XAJAX_FUNCTION` qui devient `Jaxon::USER_FUNCTION`, et  `XAJAX_EVENT` qui devient `Jaxon::BROWSER_EVENT`.
La constante `XAJAX_DEFAULT_CHAR_ENCODING` n'existe plus; il faut utiliser l'option de configuration `core.encoding` à la place.

##### Génération du code Javascript

La fonction `$jaxon->getJavascript()` qui renvoie le code javascript généré par la librairie a été séparée en 3 fonctions distinctes:

* La fonction `$jaxon->getCss()` renvoie le code qui inclut les fichiers CSS externes.
* La fonction `$jaxon->getJs()` renvoie le code qui inclut les fichiers javascript externes.
* La fonction `$jaxon->getScript()` renvoie le code javascript généré pour les classes et fonctions exportées.

Cette séparation existe parce que ces codes peuvent être insérés dans des endroits différents de la page HTML.
Toutefois, en appelant la fonction `$jaxon->getScript(true, true)`, on obtient la sortie cumulée des trois fonctions.

##### Les options de configuration

Les fonctions et les paramètres de configuration de la librairie Jaxon ont été renommés. Pour mettre à jour une option, il faut appeler la fonction `$jaxon->setOption($name, $value)`, et pour lire une valeur, il faut appeler la fonction `$jaxon->getOption($name)`. Ces deux fonctions prennent en paramètre les nouveaux noms des options.

Les fonctions `$jaxon->configure($name, $value)` et `$jaxon->getConfiguration($name)` peuvent encore être utilisée avec les anciens noms des options, mais elles sont dépréciées et seront supprimées dans une future version.

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
| scriptLoadTimeout            | js.lib.load_timeout      | |
| waitCursor                   | js.lib.show_cursor       | |
| statusMessages               | js.lib.show_status       | |
| javascript URI               | js.lib.uri               | Un ancien paramètre correspond à deux nouveaux |
| javascript URI               | js.app.uri               | Un ancien paramètre correspond à deux nouveaux |
| javascript Dir               | js.app.dir               | |
| deferDirectory               | js.app.dir               | |
| javascript files             | **deprecated**           | |
| useUncompressedScripts       | **deprecated**           | |
| deferScriptGeneration        | js.app.export            | Un ancien paramètre correspond à deux nouveaux |
| deferScriptGeneration        | js.app.minify            | Un ancien paramètre correspond à deux nouveaux |
| scriptDefferal               | js.app.options           | |
| | | |
| deferScriptValidateHash      | **deprecated**           | |
| | | |
