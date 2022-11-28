---
title: Annotations
menu: Annotations
template: jaxon
---

Annotations are an optional feature provided in the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package.

They are however recommended, since when they are used in a Jaxon class, they highly simplify the implementation of other features.

In order to use them, this package must be installed, and the `core.annotations.enabled` must be set to the boolean value `true`.
In the 2.1 version, the package provides 6 annotations instructions, for use in Jaxon classes.

- `@di`, for [dependency injection](../../05.features/03.dependency-injection/)
- `@databag`, for [data bags](../../05.features/04.databags/)
- `@upload`, for [file upload](../../05.features/06.upload/)
- `@before`, for [callbacks](../../05.features/05.hooks/) to call before the requested method
- `@after`, for [callbacks](../../05.features/05.hooks/) to call bafter the requested method
- `@exclude`, pour ne pas exporter des méthodes publiques
