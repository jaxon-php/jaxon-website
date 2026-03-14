---
title: Create and call a response plugin
menu: Response plugin
template: example
example:
    summary:
        - This example shows how to create a response plugin with custom commands.
---

The response plugin class extends the `AbstractResponsePlugin` and implements the `JsCodeGeneratorInterface` interface for Javascript code generation.
Its Javascript code registers two custom commands in the client application, which are then called in the PHP functions.
