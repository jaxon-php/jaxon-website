---
title: Les plugins d'integration
menu: Les plugins d'integration
template: jaxon
---

Les plugins d'intégration facilitent l'utilisation de Jaxon dans des frameworks et des CMS PHP.

Dans le framework ou le CMS, le plugin d'intégration fournit les fonctions d'initialisation de la librairie et de traitement des requêtes Jaxon.
Il charge automatiquement les classes Jaxon à un emplacement déterminé.

#### Installation

Pour installer un plugin d'integration Jaxon, il suffit d'installer le package correspondant avec `Composer`.
Le package [jaxon-framework](https://github.com/jaxon-php/jaxon-framework) fournit des fonctions communes à tous les plugins d'intégration.
Il doit donc être installé en même temps que le plugin.

Par exemple, voici la section `require` d'un fichier `composer.json` qui installe le plugin Jaxon pour le framework Laravel.
```json
    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.2.*",
        "jaxon-php/jaxon-core": "~1.0",
        "jaxon-php/jaxon-framework": "~1.0",
        "jaxon-php/jaxon-laravel": "1.0.*"
    },
```

Les plugins d'intégration peuvent fournir des fichiers supplémentaires à installer manuellement dans les répertoires de l'application.
Ce sont les contrôleurs, les fichiers de configuration ou de définition des routes du framework pour Jaxon.

#### Utilisation

Un plugin d'intégration de Jaxon fournit un module, une librairie ou un plugin pour son framework, qui, lorsqu'il est chargé, initialise automatiquement la librairie Jaxon et donne accès au code CSS et javascript généré.  
Les classes Jaxon étant à un emplacement déterminé, elles sont aussi automatiquement enregistrées.

Au final, utiliser la librairie Jaxon dans un framework ou un CMS revient à écrire des classes Jaxon et à les copier dans l'emplacement prévu.
Le plugin les enregistre automatiquement.

#### Configuration

Pour un framework ou un CMS, il existe un emplacement et un format pour les fichiers de configuration.  
Pour simplifier son utilisation, les plugins d'intégration permettent de lire la configuration de la librairie Jaxon à l'emplacement et au format prévus par le framework.

#### Exemples

Les plugins d'intégration suivants sont fonctionnels. Ils sont en démonstration dans la section [Exemples](../../../examples).

**[Laravel](https://github.com/jaxon-php/jaxon-laravel)** ([Exemple](../../../examples/integration/laravel))

Intègre la librairie Jaxon avec le framework [Laravel](https://laravel.com), à partir de la version 5.

**[Zend Framework](https://github.com/jaxon-php/jaxon-zend)** ([Exemple](../../../examples/integration/zend))

Intègre la librairie Jaxon avec le [Zend Framework 2](https://framework.zend.com).

**[CodeIgniter](https://github.com/jaxon-php/jaxon-codeigniter)** ([Exemple](../../../examples/integration/codeigniter))

Intègre la librairie Jaxon avec le framework [CodeIgniter](https://www.codeigniter.com), à partir de la version 3.

**[Yii](https://github.com/jaxon-php/jaxon-yii)** ([Exemple](../../../examples/integration/yii))

Intègre la librairie Jaxon avec le framework [Yii](http://www.yiiframework.com), à partir de la version 2.
