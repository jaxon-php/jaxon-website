---
title: Integration plugins
menu: Integration plugins
template: jaxon
---

Integration plugins facilitate the use of the Jaxon library in some PHP frameworks or CMS.

In the framework or CMS, the integration plugin provides functions for the library initialization and for processing Jaxon requests.
It automatically loads Jaxon classes from a specific location.

##### Installation

To install a Jaxon integration plugin, install the corresponding package with `Composer`.
The [jaxon-framework](https://github.com/jaxon-php/jaxon-framework) package provides common functions for all intégration plugins.
It must then be installed together with the plugin.

For example, this is the `require` section of a `composer.json` file which installs the Jaxon plugin for the Laravel framework.
```json
    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.2.*",
        "jaxon-php/jaxon-core": "dev-master",
        "jaxon-php/jaxon-framework": "dev-master",
        "jaxon-php/jaxon-laravel": "dev-master"
    },
```

Integration plugins can provide additional files to be manually installed in the directories of the application.
These are the controllers and the configuration or routes definition files of the framework for Jaxon.

##### Usage

An integration plugin Jaxon provides a module, a library or a plugin for the framework, which, when loaded, automatically initializes the Jaxon library and provides access to the generated CSS and javascript.
The Jaxon classes being installed in a specific location, they are also loaded automatically.

At the end, the developer only needs to write the Jaxon classes and save them in the specified location.
The Jaxon plugin will then automatically registrer them.

##### Configuration

For each framework or CMS, there are defined location and format for the configuration files.

In order to make their usage simpler, integration plugins allow to read the configuration of the Jaxon library in the location and format specified by the framework.

##### Examples

The following integration plugins are ready for use. They are demonstrated in the [Examples](../../../examples) section.

**[Laravel](https://github.com/jaxon-php/jaxon-laravel)** ([Example](../../../examples/integration/laravel))

Integrates the Jaxon library with the [Laravel](https://laravel.com) framework, starting from version 5.

**[CodeIgniter](https://github.com/jaxon-php/jaxon-codeigniter)** ([Example](../../../examples/integration/codeigniter))

Integrates the Jaxon library with the [CodeIgniter](https://www.codeigniter.com) framework, starting from version 3.

**[Yii](https://github.com/jaxon-php/jaxon-yii)** ([Example](../../../examples/integration/yii))

Integrates the Jaxon library with the [Yii](http://www.yiiframework.com) framework, starting from version 2.
