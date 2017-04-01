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

Jaxon nécessite pour son fonctionnement d'installer sa librairie javascript [jaxon-js](https://github.com/jaxon-php/jaxon-js).

Par défaut, la librairie PHP charge les fichiers javascript à partir du CDN [jsDelivr](https://www.jsdelivr.com/projects/jaxon).
Ils sont également installés sur un serveur public qui supporte les protocoles `http` et `https`, et qu'on utilise en donnant à l'option de configuration `js.lib.uri` la valeur `https://lib.jaxon-php.org/jaxon/latest/`.

Il est enfin possible de les installer sur un serveur privé, auquel cas il faut mettre à jour l'option de configuration `js.lib.uri`.
