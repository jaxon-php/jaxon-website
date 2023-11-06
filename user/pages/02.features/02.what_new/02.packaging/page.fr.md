---
title: Modularité et extensibilité
menu: Packaging
template: jaxon
---

#### Les packages

La librairie Jaxon est composée d'un package javascript-only et de plusieurs packages PHP.
Le package javascript [jaxon-js](https://github.com/jaxon-php/jaxon-js) contient le code qui gère les requêtes et les réponses dans le navigateur.
Par défaut, la librairie PHP les charge à partir du CDN [jsDelivr](https://www.jsdelivr.com/projects/jaxon).
Ils sont également installés sur un serveur public qui supporte les protocoles `http` et `https`, et qu'on utilise en donnant à l'option de configuration `js.lib.uri` la valeur `https://lib.jaxon-php.org/jaxon/latest/`.
Il est enfin possible de les installer sur un serveur privé, auquel cas il faut mettre à jour le lien avec l'option de configuration `js.lib.uri`.

Le package PHP [jaxon-core](https://github.com/jaxon-php/jaxon-core) contient le code qui gère les requêtes et les réponses sur le serveur.

Ces deux packages sont requis pour exécuter une application Jaxon. Ils peuvent être complétés par de nombreux autres plugins qui ajoutent des fonctionnalités à la librairie Jaxon, ou lui permettent de s'intégrer aisément à des frameworks ou des CMS PHP.


#### Namespaces et Composer

Tous les packages PHP de la librairie Jaxon sont namespacés, s'installent avec `Composer`, et utilisent l'autoloading `PSR-4`. Le namespace du package [jaxon-core](https://github.com/jaxon-php/jaxon-core) est `Jaxon`.

L'installation et l'utilisation de la librairie sont donc beaucoup plus simples.
