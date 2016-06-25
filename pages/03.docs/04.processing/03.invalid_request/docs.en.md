---
title: Invalid request
menu: Invalid request
template: jaxon
---

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
