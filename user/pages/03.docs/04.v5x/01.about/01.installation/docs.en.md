---
title: Installation
menu: Installation
template: jaxon
---

The Jaxon library is distributed as `Composer` packages.
To install Jaxon, add the following line in the `composer.json` file.

```json
"require": {
    "jaxon-php/jaxon-core": "~5.0"
}
```

Or run the command

```bash
composer require jaxon-php/jaxon-core:~5.0
```

#### The javascript library

Jaxon requires the [jaxon-js](https://github.com/jaxon-php/jaxon-js) javascript library to be loaded into the HTML page to operate properly.
By default, the javascript library files are loaded from the [jsDelivr CDN](https://www.jsdelivr.com/package/gh/jaxon-php/jaxon-js).

It is also possible to install the library on a private server, in which case the `js.lib.uri` configuration option must be set accordingly.

#### Global functions

By default, Jaxon places its global functions in the global namespace.
This means that the `jaxon()`, `cl()`, `rq()`, `jo()`, `jq()`, `je()`, and `attr()` functions can be called without using the corresponding `use function` statement.

In case of naming conflicts with other libraries, this operation can be disabled by setting the `app.helpers.global` option to the boolean value `false`.

```php
jaxon()->setAppOption('helpers.global', false);
```

These functions, excepted `jaxon()`, will then be available in the `Jaxon\` namespace.

```php
use function Jaxon\attr;
```
