---
title: Les attributs et les annotations
menu: Les attributs
template: jaxon
---

> Note : La gestion des attributs PHP est encore en cours de développement.

Les annotations sont optionnelles, et fournies dans le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations).
Elles sont cependant recommandées, car elles simplifient l'usage d'autres fonctions, en permettant de définir leurs paramètres de configuration dans les fichiers des classes Jaxon, plutôt que dans le fichier de configuration.

Pour les utiliser, il faut installer le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations), et donner à l'option `core.annotations.enabled` la valeur booléenne `true`.

#### Annotations disponibles

- `@di`: pour [l'injection de dépendance](../../features/dependency-injection.html).
- `@databag`: pour les [data bags](../databags.html).
- `@upload`: pour les [transfert de fichiers](../../features/upload.html).
- `@before`: pour des [hooks](../../features/hooks.html) à exécuter avant la méthode appelée.
- `@after`: pour des [hooks](../../features/hooks.html) à exécuter après la méthode appelée.
- `@exclude`: pour exclure des classes ou des méthodes publiques du [code Javascript généré](../../registrations/javascript.html).
