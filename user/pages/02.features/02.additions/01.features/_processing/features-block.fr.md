---
title: Optimisation du traitement
position: 2
read:
    text: Lire plus
    link: /fr/docs/v3x/requests/autoloading.html
---

Par défaut, toutes les classes exportées avec la librairie Jaxon sont instanciées lorsqu'une requête est traitée.

Lorsque des classes sont exportées à partir d'un répertoire, la librairie Jaxon peut être optimisée pour ne charger que la classe appelée.
D'autres classes peuvent être instanciées plus tard, ainsi seuls les objets utilisés sont créés.
