---
title: Installation
menu: Installation
template: jaxon
---

La librairie Jaxon est distribuée sous forme de packages `Composer`.

Pour l'installer, il faut ajouter la ligne suivante dans le fichier `composer.json`.
```json
"require": {
    "jaxon-php/jaxon-core": "dev-master"
}
```

Ou bien exécuter la commande
```bash
composer require jaxon-php/jaxon-core
```

#### La librairie javascript

Jaxon nécessite pour fonctionner que soit installée sa librairie javascript [jaxon-js](https://github.com/jaxon-php/jaxon-js).
Par défaut, la Jaxon charge cette librairie à partir d'un serveur public qui supporte les protocoles `http` et `https`.
Il est cependant possible de les installer sur un serveur privé, auquel cas il faut indiquer la nouvelle adresse avec l'option de configuration `js.lib.uri`.