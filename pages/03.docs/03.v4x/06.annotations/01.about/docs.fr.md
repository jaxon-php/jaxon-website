---
title: Les annotations
menu: Les annotations
template: jaxon
---

Les annotations sont optionnelles, et fournies dans le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations).

Elles sont cependant recommandées, car lorsqu'elle sont utilisées dans les classes Jaxon, elles simplifient l'usage d'autres fonctions.

Dans sa version 2.1, le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) fournit 6 instructions d'annotations à utiliser dans les classes Jaxon:

- `@di`, pour l'injection de dépendance
- `@databag`, pour les [data bags](../05.databags/)
- `@upload`, pour transférer des fichiers
- `@exclude`, pour ne pas exporter des méthodes publiques
- `@before`, pour des [callbacks](../06.callbacks/) à exécuter avant la méthode appelée
- `@after`, pour des [callbacks](../06.callbacks/) à exécuter après la méthode appelée
