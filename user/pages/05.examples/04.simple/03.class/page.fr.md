---
title: Classe Hello World
menu: Classe Hello World
template: example
example:
    summary:
        - Cet exemple montre l'export d'une classe avec Jaxon.
---

The global function `rq()` takes a class name as parameter, and returns a call factory for the methods in that class.
The calls are made using a fluent syntax, for example `rq('HelloWorld')->sayHello(1)`.
