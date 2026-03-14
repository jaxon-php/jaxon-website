---
title: Hello World Alias
menu: Hello World Alias
template: example
example:
    summary:
        - This example shows how to export a method of a class as a function with Jaxon, using aliases.
---

The `HelloWorld::sayHello(bool $isCaps)` method is exported as a function with the `helloWorld` alias.
The corresponding Ajax call is then made with `rq()->helloWorld(1)`.
