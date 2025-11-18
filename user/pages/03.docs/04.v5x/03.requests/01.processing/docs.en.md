---
title: Processing Jaxon requests
menu: Processing
template: jaxon
---

No matter how many classes are exported to javascript, an application using the Jaxon library needs only one route to process all the requests to these classes.

This is the simplest code to to attach to this route to process a request to a Jaxon class:

```php
$jaxon = jaxon();

// Configure the library and register the exported classes.

if($jaxon->canProcessRequest())
{
    $jaxon->processRequest();
}
```

The `processRequest()` method calls the function or the class targeted by the request, and sends the response back to the client.
