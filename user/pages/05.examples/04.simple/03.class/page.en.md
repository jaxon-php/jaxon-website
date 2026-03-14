---
title: Hello World Class
menu: Hello World Class
template: example
example:
    summary:
        - This example shows how to export a class with Jaxon.
---

The global function `rq()` takes a class name as parameter, and returns a call factory for the methods in that class.
The calls are made using a fluent syntax, for example `rq('HelloWorld')->sayHello(1)`.
