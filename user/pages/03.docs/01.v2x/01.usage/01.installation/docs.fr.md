---
title: Installation
menu: Installation
template: jaxon
---

La librairie Jaxon est distribuée sous forme de packages `Composer`.

Pour l'installer, il faut ajouter la ligne suivante dans le fichier `composer.json`.

```json
"require": {
    "jaxon-php/jaxon-core": "~2.0"
}
```

Ou bien exécuter la commande

```bash
composer require jaxon-php/jaxon-core:~2.0
```

#### La librairie javascript

Jaxon nécessite pour son fonctionnement d'inclure sa librairie javascript [jaxon-js](https://github.com/jaxon-php/jaxon-js) dans le code HTML.

Par défaut, la librairie PHP charge les fichiers javascript à partir du CDN [jsDelivr](https://www.jsdelivr.com/package/gh/jaxon-php/jaxon-js).

Ils sont également installés sur leur propre CDN, fourni par [KeyCDN](https://www.keycdn.com), et qui supporte les protocoles `http` et `https`.
Pour utiliser le CDN de Jaxon, on donne à l'option de configuration `js.lib.uri` la valeur `https://cdn.jaxon-php.org/libs/jaxon/1.2.0/`.
Les versions disponibles sont `1.0.0` and `1.2.0`.

Il est enfin possible de les installer sur un serveur privé, auquel cas il faut mettre à jour l'option de configuration `js.lib.uri`.
