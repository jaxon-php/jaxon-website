---
title: How it works
menu: How it works
template: jaxon
published: false
---

1. Initially, there is a PHP function defined by the developer, who wants to call it from the browser. When this function is exported, the Jaxon library creates a corresponding javascript function that will be integrated into the web page.

2. When the javascript function is called in the browser, an Ajax request is created and sent to the server. The request takes as parameters the name of the corresponding PHP function, and the parameters passed to it. The Jaxon library receives the request, and calls the PHP function, passing the parameters received.<br/>All these operations are completely managed by Jaxon, and transparent to the developer.

3. The Jaxon function creates and returns a `Jaxon\Jaxon\Response` object in which it records a set of commands to run in the browser.

4. The Jaxon library gets this response and forwards it to the browser, which automatically executes all commands it contains.
