---
title: The lifecycle of a Jaxon request
menu: Request lifecycle
template: jaxon
---

![Jaxon operation](/images/jaxon-operation.png)

1. Initially, the developer creates PHP classes that are exported using the Jaxon library. A Javascript class with the same name and functions is created for each PHP class and included in the web page.

2. When a function in a Javascript class is called in the browser, the same function in the PHP class will be called on the server, with the same parameters.

3. Actually, an Ajax request is automatically created and sent to the application. It contains the class and method names, and parameters. The Jaxon library receives this request and calls the PHP class with the incoming parameters.

5. The Jaxon library sends back this response to the browser, which automatically executes all commands it contains.

Steps 3 and 4 are handled by Jaxon and are transparent to the developer.
Its only role is to write the PHP functions that define the content and presentation of the web page.

At the end, a single Ajax call allows to execute a set of actions, defined in the server side application with PHP, in a web page.
