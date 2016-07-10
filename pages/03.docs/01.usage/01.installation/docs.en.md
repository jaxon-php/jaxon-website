---
title: Installation
menu: Installation
template: jaxon
---

The Jaxon library is distributed as `Composer` packages.

To install Jaxon, add the following line in the `composer.json` file.
```json
"require": {
    "jaxon-php/jaxon-core": "dev-master"
}
```

Or run the command
```bash
composer require jaxon-php/jaxon-core
```

#### The javascript library

Jaxon requires the [jaxon-js](https://github.com/jaxon-php/jaxon-js) javascript library to be loaded into the HTML page to operate properly.
By default, Jaxon loads the library from a public server that supports the `http` and `https` protocols.
It is possible to install them on a private server, in which case the new address must be specified with the `js.lib.uri` configuration option.
