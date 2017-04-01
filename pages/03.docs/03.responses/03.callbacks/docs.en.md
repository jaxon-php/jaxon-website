---
title: Callbacks
menu: Callbacks
template: jaxon
published: true
---

Jaxon allows the developer to specify a callback function that will be called before the execution of each request.
It is defined in one of the following ways.
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, array($object, 'methodName'));
```

The callback function takes a boolean parameter `$bEndRequest` passed by reference, and returns a Jaxon response. The parameter value equals to `false` before the function is called.
If the parameter is assigned to `true` in the function, the request processing is stopped, and the returned response is sent back to the browser.
```php
function preProcess(&$bEndRequest)
{
}
```

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

Jaxon also allows the developer to specify a function to be called when an invalid request is received.
It is defined in one of the following ways.
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, array($object, 'methodName'));
```

The callback function takes as a parameter the error message returned when processing the request.
The response to the Jaxon request is reset, and if the callback returns one, it will also be that of the request.

```php
function invalidRequest($sMessage)
{
}
```
