---
title: Callbacks
menu: Callbacks
template: jaxon
published: true
---

Jaxon allows the developer to specify callbacks that will be called at different steps during the execution of each request.

#### Before processing the request

```php
$jaxon->callback()->before(function($target, &$bEndRequest) {});
```

The provided callback must accept the following parameters.

```php
/**
 * @param Jaxon\Request\Target  $target         The function or class method to be called.
 * @param boolean               &$bEndRequest   Set this to true to end the request.
 *
 * @return Jaxon\Response\Response
 */
```

The parameter `$target` allows to retrieve the called function or class, as follows.

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

The boolean parameter `$bEndRequest` is passed by reference. Its initial value is `false`, and if it is assigned the value `true` in the callback, the request processing is stopped, and the returned response is sent back to the browser.

#### After processing the request

```php
$jaxon->callback()->after(function($target, $bEndRequest) {});
```

The parameters are the same as in the `before()` callback, except that `$bEndRequest` is passed by value and not by reference.
If the callback returns a Jaxon response, it is then appended to the current response.

#### In the case of an invalid request

```php
$jaxon->callback()->invalid(function($sMessage) {});
```

The callback parameter is the error message returned when processing the request.
The response to the Jaxon request is reset, and if the callback returns one, it will also be that of the request.

#### In the case of a processing error

```php
$jaxon->callback()->error(function($xException) {});
```

The parameter is the exception thrown while processing the request.
The response to the Jaxon request is reset, and if the callback returns one, it will also be that of the request.
