---
title: The lifecycle of a Jaxon request
menu: Request lifecycle
template: jaxon
---

1. Initially, there is a PHP class defined by the developer. When this class is registered with the Jaxon library, a javascript class with the same name (and a configurable prefix) is created and included into the web page.

2. When the javascript class is called in the browser, an Ajax request is automatically created and sent to the application. The request takes as parameters the names of the PHP class and method, and the parameters passed to it.

3. The Jaxon library receives the request, and calls the PHP class, passing the parameters received.<br/>

4. The Jaxon classes called during the request processing populate a `Response` object with a set of commands to run in the browser.

5. The Jaxon library sends back this response to the browser, which automatically executes all commands it contains.

The steps 2, 3 and 5 are completely managed by Jaxon, and transparent to the developer.
Its only role is to write the PHP functions which define the content and the presentation of the web page.

At the end, a single Ajax call allows to execute a large set of actions, defined in the application with PHP, in a web page.
