---
title: How it works
menu: How it works
template: jaxon
---

#### Armada

The main objective of Armada is to further simplify the use of Jaxon, while functionally enriching it.

With Armada, the Jaxon library bootstraps from a single configuration file, and its [classes](/docs/armada/classes) automatically inherit from a rich set of functionalities for handling classes, Ajax requests, pagination, views, sessions, etc.

The Armada configuration is separated into two sections, containing respectively the settings of the library and those of the classes and the views.

#### Installation

Armada is distributed in a separated package, which is installed by adding the following line in the `composer.json` file.

```json
"require": {
    "jaxon-php/jaxon-armada": "~2.0"
}
```

#### Sentry

Armada depends on [Sentry](https://github.com/jaxon-php/jaxon-sentry), a package which provides a common API for all frameworks integration packages, including functions to manage [sessions](/docs/armada/sessions) and [views](/docs/armada/views).

A class written for Armada should then work on any other framework with minimum or even no change, thus allowing to write full-featured and cross-framework PHP packages.
