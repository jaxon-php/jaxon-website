---
title: Fonction Hello World
menu: Fonction Hello World
template: example
example:
    summary:
        - Cet exemple montre l'export d'une fonction avec Jaxon.
---

The global function `rq()`, called without a parameter, returns a factory which can make Ajax calls to exported functions.
`rq()->helloWorld(1)` calls the exported `function helloWorld(bool $isCaps)`.
