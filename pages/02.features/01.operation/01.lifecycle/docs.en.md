---
title: The lifecycle of a Jaxon request
menu: Request lifecycle
template: jaxon
published: false
---

1. Initially, there is a PHP class defined by the developer. When this class is exported with the Jaxon library, a javascript class with the same name (and a configurable prefix) is created and integrated into the web page.

2. When the javascript class is called in the browser, an Ajax request is automatically created and sent to the server. The request takes as parameters the name of the PHP class, and the parameters passed to it. The Jaxon library receives the request, and calls the PHP class, passing the parameters received.<br/>
All these operations are completely managed by Jaxon, and transparent to the developer.

3. The Jaxon class created by the developer returns a `Response` object in which it has recorded a set of commands to run in the browser.

4. The Jaxon library sends back this response to the browser, which automatically executes all commands it contains.

At the end, only a single javascript call in a web page is required to perform any set of actions, which are defined on server-side with PHP.
