---
title: Features
menu: Features
template: jaxon
---

The Jaxon library is the result of the refactoring of the [Xajax](http://www.xajax-project.org?target=_blank) library.
Its main features, namely [exporting functions](../../docs/v3x/registrations/functions) and [exporting classes](../../docs/v3x/registrations/classes) from PHP to javascript, have been preserved.
The `Response` object which is involved in most of the code written for the library, is kept unchanged.

The library has been modified to take advantage of the most advanced features of the PHP language: autoloading, namespacing, traits and dependency injection.
It is now more concise, easier to understand, maintain and evolve.

New features have also been added to the library.
It is now possible to [register all the classes in a directory](../../../docs/v3x/registrations/directories) in one shot, to read the library settings from a [configuration file](../../../docs/v3x/about/configuration), or to [setup pagination](../../../docs/v3x/requests/pagination).
