---
title: Installation
menu: Installation
template: jaxon
---

La librairie Jaxon est distribuée sous forme de packages `Composer`.
Pour l'installer, il faut ajouter la ligne suivante dans le fichier `composer.json`.

```json
"require": {
    "jaxon-php/jaxon-core": "~5.0"
}
```

Ou bien exécuter la commande

```bash
composer require jaxon-php/jaxon-core:~5.0
```

#### La librairie javascript

Jaxon nécessite pour son fonctionnement d'inclure sa librairie javascript [jaxon-js](https://github.com/jaxon-php/jaxon-js) dans le code HTML.
Par défaut, la librairie PHP charge les fichiers javascript à partir du CDN [jsDelivr](https://www.jsdelivr.com/package/gh/jaxon-php/jaxon-js).

Il est aussi possible de les installer sur un serveur privé, auquel cas il faut mettre à jour l'option de configuration `js.lib.uri`.

#### Fonctions globales

Par défaut, Jaxon place ses fonctions globales dans l'espace de nom global.
On peut donc appeler les fonctions `jaxon()`, `cl()`, `rq()`, `jo()`, `jq()`, `je()`, et `attr()` sans utiliser l'instruction `use function` correspondante.

En cas de conflit de nommage avec d'autres librairies, cette opération peut être désactivée en passant l'option `app.helpers.global` à la valeur booléenne `false`.
Ces fonctions seront alors disponibles dans le namespace `Jaxon\`.

```php
use function Jaxon\attr;
```
