---
title: Créer et appeler un plugin de réponse
menu: Plugin de réponse
template: example
example:
    summary:
        - Cet exemple montre comment créer un plugin de réponse et ses commandes.
---

The response plugin class extends the `AbstractResponsePlugin` and implements the `JsCodeGeneratorInterface` interface for Javascript code generation.
Its Javascript code registers two custom commands in the client application, which are then called in the PHP functions.
