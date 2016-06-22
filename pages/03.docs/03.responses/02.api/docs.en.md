---
title: The response API
menu: The response API
template: docs
---

An Jaxon response contains a list of commands to be executed in the browser in response to an Jaxon request.
The `Jaxon\Response\Response` class implements a set of functions to manage those commands, and thus perform various actions in the browser.

The following code displays an alert message.
```php
$response->alert('What you say?!');
``` 

The following code assigns a text to an HTML block identified by its id.
```php
$response->assign('message-id', 'innerHTML', 'The new Jaxon is cool');
``` 

The complete list of functions of the `Jaxon\Response\Response` class is [documented here](http://www.jaxon-php.org/docs/api/class-Jaxon.Response.Response.html).

Although the `Jaxon\Response\Response` class implements a rich set of features, it can be extended using plugins, which are described later in this document.
