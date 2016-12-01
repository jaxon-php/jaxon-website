---
title: Modularity and extensibility
menu: Packaging
template: jaxon
---

#### The packages

The Jaxon library is composed of a pure javascript package and several PHP packages.

The javascript package [jaxon-js](https://github.com/jaxon-php/jaxon-js) contains the code that manages requests and responses in the browser.
By default, the javascript library files are loaded from the [jsDelivr CDN](https://www.jsdelivr.com/projects/jaxon).
They are also installed on a public server, which supports the `http` and `https` protocols, and which is used by setting the configuration option `js.lib.uri` to `https://lib.jaxon-php.org/jaxon/latest/`.
It is also possible to install them on a private server, in which case the `js.lib.uri` configuration option must be updated accordingly.

The PHP package [jaxon-core](https://github.com/jaxon-php/jaxon-core) contains the code that manages requests and responses on the server.

These two packages are required to run a Jaxon application. They can be supplemented by many other plugins that add functionality to the Jaxon library, or allow it to easily integrate with popular PHP frameworks or CMS.

#### Namespaces and Composer

All PHP packages composing the Jaxon library are namespaced, install with `Composer`, and use the `PSR-4` autoloading. The namespace of the [jaxon-core](https://github.com/jaxon-php/jaxon-core) package is `Jaxon`.

The installation and use of the library are much simpler.
