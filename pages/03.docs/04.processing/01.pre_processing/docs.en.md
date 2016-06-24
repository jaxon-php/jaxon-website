---
title: Pre-processing event
menu: Pre-processing
template: docs
---

Jaxon allows the developer to specify a callback function that will be called before the execution of each request.
It is defined in one of the following ways.
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, array($object, 'methodName'));
```

The callback function takes a boolean parameter passed by reference, and returns an Jaxon response. The parameter value equals to `false` before the function is called.
If the parameter is assigned to `true` in the function, the request processing is stopped, and the returned response is sent back to the browser.
```php
function preProcess(&$bEndRequest)
{
}
```
