---
title: Migrer de Xajax vers Jaxon
menu: Migrer de Xajax
template: jaxon
---

Bien que la librairie Jaxon ait subi de nombreux changements, la classe `Response`, qui intervient dans la plus grande partie du code écrit dans une application Jaxon, n'a pas été modifiée. Ceci va rendre plus simple la migration des applications existantes.

Voici les étapes à suivre pour passer d'une version précédente de Xajax à Jaxon.

1. Vérifier que l'application n'utilise pas l'une des classes qui ont été supprimées.
2. Installer le package `jaxon-core` avec `Composer`, et charger son autoloader dans l'application.
3. Accéder à l'objet principal avec `$jaxon = jaxon($sRequestURI, $sLanguage)`, et pour les réponses instancier la classe `Jaxon\Response\Response`.
4. Définir les nouvelles options de configuration avec la fonction `$jaxon->setOption()`, en particulier les options `core.request.uri` et `core.language` qui remplacent les paramètres `$sRequestURI` et `$sLanguage` du constructeur de la classe `xajax`.
5. Afficher le code javascript et CSS dans la page HTML avec les appels aux fonctions `$jaxon->getCss()`, `$jaxon->getJs()` et `$jaxon->getScript()`.  

Ces étapes sont suffisantes pour éxécuter une application existante avec la nouvelle version de la librairie.
Pour tirer pleinement parti des nouveautés, les étapes optionnelles suivantes peuvent être exécutées.

* Regrouper les options de configuration de la librairie Jaxon dans un fichier de configuration, et charger celui-ci.
* Regrouper les classes Jaxon de l'application dans un répertoire, leur associer un namespace, et exporter le contenu du répertoire.
* Utiliser un ou plusieurs plugins, en les installant avec `Composer`.
* Installer les fichiers de la librairie javascript sur un serveur privé, et mettre à jour le lien avec l'option de configuration `js.lib.uri`.

Consulter les pages [New features](../../../features/differences/added), [Evolved features](../../../features/differences/changed) et [Deprecated features](../../../features/differences/deprecated) pour en savoir plus sur les différences entre Xajax et Jaxon.
