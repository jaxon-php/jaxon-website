---
title: Accueil
menu: Accueil
template: home
content:
    items: '@self.modular'
    order:
        by: header.position
        dir: asc
        custom:
            - _motivations
            - _operation
            - _features
#            - _plugins
            - _integrations
---

## Une librarie PHP pour Ajax

Jaxon est une librairie PHP open source pour créer des applications web Ajax.

Il permet dans une page web d'appeler directement avec Ajax des classes PHP, qui vont en retour modifier son contenu, sans recharger la page entière.

Jaxon propose un ensemble complet de fonctions pour définir le contenu et les propriétés d'une page web avec PHP.
Plusieurs plugins permettent d'étendre ses fonctionnalités et l'intégrer avec divers frameworks PHP.

&Agrave; partir de la version 2, Jaxon implémente un module qui simplifie encore son usage, et enrichit ses fonctions de génération de code HTML et javascript.

Le module de Jaxon permet d'écrire des classes complètes, avec vues et sessions, qui peuvent etre réutilisées avec des frameworks PHP différents.
