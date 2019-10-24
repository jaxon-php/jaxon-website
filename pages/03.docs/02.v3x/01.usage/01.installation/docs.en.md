---
title: Installation
menu: Installation
template: jaxon
---

The Jaxon library is distributed as `Composer` packages.

To install Jaxon, add the following line in the `composer.json` file.

```json
"require": {
    "jaxon-php/jaxon-core": "~3.0"
}
```

Or run the command

```bash
composer require jaxon-php/jaxon-core:~3.0
```

#### The javascript library

Jaxon requires the [jaxon-js](https://github.com/jaxon-php/jaxon-js) javascript library to be loaded into the HTML page to operate properly.

By default, the javascript library files are loaded from the [jsDelivr CDN](https://www.jsdelivr.com/projects/jaxon).

They are also installed on their own CDN, powered by [KeyCDN](https://www.keycdn.com), which supports the `http` and `https` protocols.
The Jaxon CDN is used by setting the configuration option `js.lib.uri` to `https://cdn.jaxon-php.org/libs/jaxon/1.2.0/`.
The currently available versions are `1.0.0` and `1.2.0`.

It is also possible to install the library on a private server, in which case the `js.lib.uri` configuration option must be set accordingly.
