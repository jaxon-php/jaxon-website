---
title: PHP Callbacks
menu: PHP Callbacks
template: jaxon
published: true
---

Jaxon allows the developer to specify global functions that will be called at different steps during the execution of each request in the PHP application.

#### Before processing the request

```php
$jaxon->callback()->before(function($target, &$bEndRequest) {});
```

The provided callback must accept the following parameters.

```php
/**
 * @param Jaxon\Request\Target  $target         The function or class method to be called.
 *
 * @return bool
 */
```

The `$target` parameter allows to retrieve the called function or class, as follows.

```php
    if($target->isFunction())
    {
        $function = $target->getFunctionName();
    }
    elseif($target->isClass())
    {
        $class = $target->getClassName();
        $method = $target->getMethodName();
    }
```

If the callback returns the value `true`, the request processing is stopped, and the response is sent back to the browser.

#### After processing the request

```php
$jaxon->callback()->after(function($target, $bEndRequest) {});
```

The `$target` parameter is the same as in the `before()` callback, and `$bEndRequest` is its return value.

#### In the case of an invalid request

```php
$jaxon->callback()->invalid(function($sMessage) {});
```

The callback parameter is the error message returned when processing the request.
The response to the Jaxon request is reset before the callback is called.

#### In the case of a processing error

```php
$jaxon->callback()->error(function($xException) {});
```

The parameter is the exception thrown while processing the request.
The response to the Jaxon request is reset before the callback is called.
