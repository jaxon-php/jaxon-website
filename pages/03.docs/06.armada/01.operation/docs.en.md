---
title: How it works
menu: How it works
template: jaxon
---

#### Armada

The main objective of Armada is to further simplify the use of Jaxon, while functionally enriching it.

With Armada, an application bootstraps from a single configuration file, and its [classes](/docs/armada/classes) automatically inherit from a rich set of functionalities.
Armada only allows to export PHP classes with a namespace, and not functions.

In addition to the library settings, the configuration of Armada indicates the directories where the classes and the views of the application are located.

#### Sentry

Armada depends on [Sentry](https://github.com/jaxon-php/jaxon-sentry), a package which provides a common API for all frameworks integration packages, including functions to manage [sessions](/docs/armada/sessions) and [views](/docs/armada/views).

A class written for Armada should then work on any other framework with minimum or even no change, thus allowing to write full-featured and cross-framework PHP packages.
