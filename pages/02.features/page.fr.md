---
title: Fonctionnalités
menu: Fonctionnalités
template: jaxon
---

La librairie Jaxon est le résultat du refactoring de la librairie [Xajax](http://www.xajax-project.org?target=_blank).
Ses principales fonctionnalités, à savoir [exporter des fonctions](../../docs/requests/objects) et [exporter des objets](../../docs/requests/objects) de PHP vers javascript, ont été conservées.
De plus, l'objet `Response` qui intervient dans la majeure partie du code écrit pour la librairie, n'a pas été modifié.

La librairie a été modifiée pour tirer parti des fonctions avancées du langage PHP: autoloading, namespacing, traits et injection de dépendance.
Elle est maintenant plus concise, plus simple à comprendre, à maintenir et à faire évoluer.

De nouvelles fonctionnalités ont également été ajoutées à la librairie.
Il est maintenant possible d'[exporter en une fois toutes les classes d'un répertoire](../../../docs/advanced/directories), de lire la [configuration de la librairie](../../../docs/usage/configuration) dans un fichier, ou encore de [faire de la pagination](../../../docs/advanced/pagination).
