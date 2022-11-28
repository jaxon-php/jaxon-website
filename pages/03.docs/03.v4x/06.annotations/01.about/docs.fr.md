---
title: Les annotations
menu: Les annotations
template: jaxon
---

Les annotations sont optionnelles, et fournies dans le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations).

Elles sont cependant recommandées, car lorsqu'elle sont utilisées dans les classes Jaxon, elles simplifient l'usage d'autres fonctions.

Pour les utiliser, il faut donc installer ce package, et donner à l'option `core.annotations.enabled` la valeur booléenne `true`.
Dans sa version 2.1, le package fournit 6 instructions d'annotations à utiliser dans les classes Jaxon:

- `@di`, pour [l'injection de dépendance](../../05.features/03.dependency-injection/)
- `@databag`, pour les [data bags](../../05.features/04.databags/)
- `@upload`, pour les [transfert de fichiers](../../05.features/06.upload/)
- `@before`, pour des [hooks](../../05.features/05.hooks/) à exécuter avant la méthode appelée
- `@after`, pour des [hooks](../../05.features/05.hooks/) à exécuter après la méthode appelée
- `@exclude`, pour ne pas exporter des méthodes publiques
