---
title: Post-processing event
menu: Post-processing
template: jaxon
---

Jaxon allows the developer to specify a callback function that will be called after execution of each request.
It is defined in one of the following ways.
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_AFTER, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_AFTER, array($object, 'methodName'));
```

The callback function should take a boolean parameter, which is the same the `pre-processing` callback received. It indicates whether the Jaxon request was processed.
If this function returns a Jaxon response, it is then appended to the current response.
```php
function postProcess($bEndRequest)
{
}
```
