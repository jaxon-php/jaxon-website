---
title: Comment ça marche
menu: Comment ça marche
template: jaxon
---

L'objectif de Armada est de simplifier encore l'utilisation de Jaxon, tout en l'enrichissant fonctionnellement.

Avec Armada, une application Jaxon démarre à partir d'un fichier de configuration, et ses [classes](/docs/armada/classes) héritent automatiquement d'un riche ensemble de fonctions.

Armada s'appuie sur [Sentry](https://github.com/jaxon-php/jaxon-sentry), un package qui fournit une API commune à tous les packages d'intégration de frameworks, avec des fonctions de gestion des [sessions](/docs/armada/sessions) et des [vues](/docs/armada/views).

Une classe Jaxon écrite pour Armada devrait fonctionner sur n'importe quel framework avec un minimum, voire pas de changement, permettant ainsi de créer des packages PHP complets et multi-framework.  

Par contre, il permet d'exporter uniquement des classes PHP avec un namespace, et pas des fonctions.
