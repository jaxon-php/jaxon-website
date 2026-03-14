---
title: Alias Hello World
menu: Alias Hello World
template: example
example:
    summary:
        - Cet exemple montre l'export d'une méthode d'une classe comme une fonction, à l'aide d'alias.
---

The `HelloWorld::sayHello(bool $isCaps)` method is exported as a function with the `helloWorld` alias.
The corresponding Ajax call is then made with `rq()->helloWorld(1)`.
