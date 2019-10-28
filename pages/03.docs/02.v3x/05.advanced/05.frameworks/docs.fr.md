---
title: Les plugins d'integration
menu: Les plugins d'integration
template: jaxon
---

Les plugins d'intégration facilitent l'utilisation de Jaxon dans des frameworks ou des CMS PHP.

Dans le framework ou le CMS, le plugin d'intégration fournit les fonctions d'initialisation de la librairie et de traitement des requêtes Jaxon.
Il charge automatiquement les classes Jaxon à un ou plusieurs emplacements indiqué dans la configuration.

#### Installation

Pour installer un plugin d'integration Jaxon, il suffit d'installer le package correspondant avec `Composer`.

```json
    "require": {
        "laravel/framework": "5.6.*",
        "jaxon-php/jaxon-laravel": "3.0.*"
    },
```

Les plugins d'intégration peuvent fournir des fichiers supplémentaires à installer manuellement dans les répertoires de l'application.

#### Configuration

Pour un framework ou un CMS, il existe un emplacement et un format pour les fichiers de configuration.
Pour simplifier son utilisation, les plugins d'intégration permettent de lire la configuration de la librairie Jaxon à l'emplacement et au format prévus par le framework.

#### Utilisation

Un plugin d'intégration de Jaxon fournit un module, une librairie ou un plugin pour son framework, qui, lorsqu'il est chargé, initialise automatiquement la librairie Jaxon et donne accès au code CSS et javascript généré.
Les classes Jaxon étant à un emplacement déterminé, elles sont aussi automatiquement enregistrées.

Au final, utiliser la librairie Jaxon dans un framework ou un CMS revient à écrire des classes Jaxon et à les copier dans l'emplacement prévu.
Le plugin les enregistre automatiquement.

#### Exemples

Les plugins d'intégration suivants sont fonctionnels. Ils sont en démonstration dans la section [Exemples](/examples).

**[Laravel](https://github.com/jaxon-php/jaxon-laravel)** ([Exemple](/examples/integration/laravel))

Intègre la librairie Jaxon avec le framework [Laravel](https://laravel.com), à partir de la version 5.

**[Symfony](https://github.com/jaxon-php/jaxon-symfony)** ([Exemple](/examples/integration/symfony))

Intègre la librairie Jaxon avec le framework [Symfony](http://symfony.com), de la version 2.8 à la version 3.

**[Zend Framework](https://github.com/jaxon-php/jaxon-zend)** ([Exemple](/examples/integration/zend))

Intègre la librairie Jaxon avec le [Zend Framework](https://framework.zend.com), de la version 2.3 à la version 3.

**[CodeIgniter](https://github.com/jaxon-php/jaxon-codeigniter)** ([Exemple](/examples/integration/codeigniter))

Intègre la librairie Jaxon avec le framework [CodeIgniter](https://www.codeigniter.com), à partir de la version 3.

**[Yii](https://github.com/jaxon-php/jaxon-yii)** ([Exemple](/examples/integration/yii))

Intègre la librairie Jaxon avec le framework [Yii](http://www.yiiframework.com), à partir de la version 2.

**[CakePHP](https://github.com/jaxon-php/jaxon-cake)** ([Exemple](/examples/integration/cake))

Intègre la librairie Jaxon avec le framework [CakePHP](https://cakephp.org), à partir de la version 3.
