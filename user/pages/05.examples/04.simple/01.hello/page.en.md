---
title: Hello World Function
menu: Hello World Function
template: example
example:
    summary:
        - This example shows how to export a function with Jaxon.
---

The global function `rq()`, called without a parameter, returns a factory which can make Ajax calls to exported functions.
`rq()->helloWorld(1)` calls the exported `function helloWorld(bool $isCaps)`.
