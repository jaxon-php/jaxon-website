---
title: Comment ça marche
menu: Comment ça marche
template: jaxon
---

#### Armada

L'objectif de Armada est de simplifier encore l'utilisation de Jaxon, tout en l'enrichissant fonctionnellement.

Avec Armada, la librairie Jaxon s'initialise à partir d'un fichier de configuration, et ses [classes](/docs/armada/classes) héritent automatiquement d'un riche ensemble de fonctions, pour gérer les classes, les requêtes, la pagination, les vues, les sessions, etc.

la configuration de Armada est séparée en deux sections qui contiennent respectivement les paramètres de la librairie, et ceux des classes et des vues.

#### Installation

Armada est distribué dans un package séparé, qu'on installe en ajoutant la ligne suivante dans le fichier `composer.json`.

```json
"require": {
    "jaxon-php/jaxon-armada": "~2.0"
}
```

#### Sentry

Armada s'appuie sur [Sentry](https://github.com/jaxon-php/jaxon-sentry), un package qui fournit une API commune à tous les packages d'intégration de frameworks, avec des fonctions de gestion des [sessions](/docs/armada/sessions) et des [vues](/docs/armada/views).

Une classe Jaxon écrite pour Armada devrait fonctionner sur n'importe quel framework avec un minimum, voire pas de changement, permettant ainsi de créer des packages PHP complets et multi-framework.  
