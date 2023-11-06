---
title: Integration plugins
menu: Integration plugins
template: jaxon
---

Integration plugins facilitate the use of the Jaxon library in some PHP frameworks and CMS.

In the framework or CMS, the integration plugin provides functions for the library initialization and for processing Jaxon requests.
It automatically loads Jaxon classes from a specific location.

#### Installation

To install a Jaxon integration plugin, install the corresponding package with `Composer`.

```json
    "require": {
        "laravel/framework": "5.2.*",
        "jaxon-php/jaxon-laravel": "2.0.*"
    },
```

Integration plugins can provide additional files to be manually installed in the directories of the application.
These are the controllers and the configuration or routes definition files of the framework for Jaxon.

#### Usage

An integration plugin Jaxon provides a module, a library or a plugin for the framework, which, when loaded, automatically initializes the Jaxon library and provides access to the generated CSS and javascript.
Since the Jaxon classes are installed in a specific location, they are also automatically loaded.

At the end, the developer only needs to write the Jaxon classes and save them in the specified location.
The Jaxon plugin will then automatically registrer them.

#### Configuration

For each framework or CMS, there are defined location and format for the configuration files.

In order to make their usage simpler, integration plugins allow to read the configuration of the Jaxon library in the location and format specified by the framework.

#### Examples

The following integration plugins are ready for use. They are demonstrated in the [Examples](/examples) section.

**[Laravel](https://github.com/jaxon-php/jaxon-laravel)** ([Example](/examples/integration/laravel))

Integrates the Jaxon library with the [Laravel](https://laravel.com) framework, starting from version 5.

**[Symfony](https://github.com/jaxon-php/jaxon-symfony)** ([Example](/examples/integration/symfony))

Integrates the Jaxon library with the [Symfony](http://symfony.com) framework, from version 2.8 to 3.

**[Zend Framework](https://github.com/jaxon-php/jaxon-zend)** ([Example](/examples/integration/zend))

Integrates the Jaxon library with the [Zend Framework](https://framework.zend.com), from version 2.3 to 3.

**[CodeIgniter](https://github.com/jaxon-php/jaxon-codeigniter)** ([Example](/examples/integration/codeigniter))

Integrates the Jaxon library with the [CodeIgniter](https://www.codeigniter.com) framework, starting from version 3.

**[Yii](https://github.com/jaxon-php/jaxon-yii)** ([Example](/examples/integration/yii))

Integrates the Jaxon library with the [Yii](http://www.yiiframework.com) framework, starting from version 2.

**[CakePHP](https://github.com/jaxon-php/jaxon-cake)** ([Exemple](/examples/integration/cake))

Integrates the Jaxon library with the [CakePHP](https://cakephp.org), framework, starting from version 3.
