---
title: Les extensions Jaxon
menu: Les extensions Jaxon
template: jaxon
---

L'architecture de la librairie Jaxon est modulaire.
Plusieurs de ses fonctions sont conçues sous forme d'extensions qui se greffent au coeur de la librairie.
C'est le cas des fonctions de déclaration des classes et des fonctions à exporter, ou encore des databags et de la pagination.

Les fonctions de la librairie peuvent dont être enrichies avec plusieurs types d'extensions.

Les [plugins de réponse](../response.html) sont les plus communs. Ils ajoutent de nouvelles fonctionnalités à l'objet `Response`, et fournissent des fonctions avancées d'UI, telles que les dialogues ou l'upload.

Les [plugins de requête](../request.html) sont beaucoup plus rares. Ils ajoutent à la librairie de nouveaux types d'objets à enregistrer, en plus des classes et des fonctions, et ils génèrent le code Javascript correspondant.

Les [extensions de vues](../views.html) connectent les moteurs de templates à l'API d'affichage des vues de Jaxon.

Le [plugin Dialog](../../ui-features/dialogs.html) est un cas spéciial dans l'univers Jaxon. C'est un [plugin de réponse](../response.html), mais qui peut ête étendu avec [ses propres extensions](../dialogs.html).

Les [extensions d'intégration](../../integrations/about.html) n'enrichissent pas les fonctions de la librairie, mais servent plutôt à simplifier son utilisation avec les frameworks ou les CMS PHP les plus courants, tels Laravel ou Symfony.

Les [packages Jaxon](../packages.html) sont des modules logiciels complets qui implémentent les fonctions backend et frontend d'une solution. Ils sont destinés à être intégrés dans une page d'une application PHP existante.
