---
title: Annotations
menu: Annotations
template: jaxon
---

Annotations are an optional feature provided in the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package.

They are however recommended, since when they are used in a Jaxon class, they highly simplify the implementation of other features.

In the 2.1 version, the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package provides 6 instructions for annotations for use in Jaxon classes.

- `@di`, for dependency injection
- `@databag`, for [data bags](../05.databags/)
- `@upload`, for file upload
- `@exclude`, pour ne pas exporter des méthodes publiques
- `@before`, for [callbacks](../06.callbacks/) to call before the requested method
- `@after`, for [callbacks](../06.callbacks/) o call bafter the requested method
