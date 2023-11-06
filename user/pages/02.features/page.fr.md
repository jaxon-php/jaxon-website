---
title: Fonctionnalités
menu: Fonctionnalités
template: jaxon
---

La librairie Jaxon est le résultat du refactoring de la librairie [Xajax](http://www.xajax-project.org?target=_blank).
Ses principales fonctionnalités, à savoir [exporter des fonctions](../../docs/v3x/registrations/functions) et [exporter des classes](../../docs/v3x/registrations/classes) de PHP vers javascript, ont été conservées.
L'objet `Response` qui intervient dans la majeure partie du code écrit pour la librairie, n'a pas été modifié.

La librairie a été modifiée pour tirer parti des fonctions avancées du langage PHP: autoloading, namespacing, traits et injection de dépendance.
Elle est maintenant plus concise, plus simple à comprendre, à maintenir et à faire évoluer.

De nouvelles fonctionnalités ont également été ajoutées à la librairie.
Il est maintenant possible d'[exporter en une fois toutes les classes d'un répertoire](../../../docs/v3x/registrations/directories), de lire la [configuration de la librairie](../../../docs/v3x/about/configuration) dans un fichier, ou encore de [faire de la pagination](../../../docs/v3x/requests/pagination).
