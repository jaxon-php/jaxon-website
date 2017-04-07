---
title: Callbacks
menu: Callbacks
template: jaxon
published: true
---

Jaxon allows the developer to specify callbacks that will be called at different steps during the execution of each request.

#### Before processing the request

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

#### After processing the request

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

#### In the case of an invalid request

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

#### In the case of a processing error

This callback is available since version 2.

```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_ERROR, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_ERROR, array($object, 'methodName'));
```

The callback function takes as a parameter the exception thrown while processing the request.
The response to the Jaxon request is reset, and if the callback returns one, it will also be that of the request.

```php
function invalidRequest($xException)
{
}
```
