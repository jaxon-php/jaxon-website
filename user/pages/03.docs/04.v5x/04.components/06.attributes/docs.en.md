---
title: Attributes and annotations
menu: Attributes
template: jaxon
---

> Note: The PHP attributes management is still under development.

Annotations are an optional feature provided in the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package.
They are however recommended, since they highly simplify the implementation of other features, by allowing to define their configuration parameters in the same files as the Jaxon classes, rather than in the configuration file.

Before they can be used, the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package must be installed, and the `core.annotations.enabled` option must be set to the boolean value `true`.

#### Available annotations

- `@di`: for [dependency injection](../../features/dependency-injection.html).
- `@databag`: for [data bags](../databags.html).
- `@upload`: for [file upload](../../features/upload.html).
- `@before`: for [callbacks](../../features/hooks.html) to call before the requested method.
- `@after`: for [callbacks](../../features/hooks.html) to call bafter the requested method.
- `@exclude`: to exclude classes or public methods from the [generated Javascript code](../../registrations/javascript.html).
