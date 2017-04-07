---
title: Edit webpage contents from PHP
menu: Webpage contents
template: jaxon
---

The `Response` object returned in response to a Jaxon request contains a list of commands to be executed in the browser.
The `Jaxon\Response\Response` class implements a set of functions each adding a specific command to the set.

For example, the following code displays an alert message.
```php
$response->alert('What you say?!');
``` 

The following code assigns a text to an HTML block identified by its id.
```php
$response->assign('message-id', 'innerHTML', 'Jaxon is cool');
``` 

The complete list of functions of the `Jaxon\Response\Response` class is [documented here](/api/Jaxon/Plugin/Response.html).

Although the `Jaxon\Response\Response` class implements a rich set of features, it can be extended using [plugins](../../plugins/response).
