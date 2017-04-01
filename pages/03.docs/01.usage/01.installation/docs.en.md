---
title: Installation
menu: Installation
template: jaxon
---

The Jaxon library is distributed as `Composer` packages.

To install Jaxon, add the following line in the `composer.json` file.
```json
"require": {
    "jaxon-php/jaxon-core": "~2.0"
}
```

Or run the command
```bash
composer require jaxon-php/jaxon-core:~2.0
```

#### The javascript library

Jaxon requires the [jaxon-js](https://github.com/jaxon-php/jaxon-js) javascript library to be loaded into the HTML page to operate properly.

By default, the javascript library files are loaded from the [jsDelivr CDN](https://www.jsdelivr.com/projects/jaxon).
They are also installed on a public server, which supports the `http` and `https` protocols, and which is used by setting the configuration option `js.lib.uri` to `https://lib.jaxon-php.org/jaxon/latest/`.

It is also possible to install the library on a private server, in which case the `js.lib.uri` configuration option must be set accordingly.
