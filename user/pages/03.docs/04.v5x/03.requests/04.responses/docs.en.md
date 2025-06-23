---
title: Using the Response object
menu: Responses
template: jaxon
---

A Jaxon response provides [functions to generate the commands](../../requests/responses.html) to be executed in the browser in response to a Jaxon request.

By default there is a response in the library Jaxon which is returned by the `jaxon()->getResponse()` call.
However, it is possible to create others, by calling the `jaxon()->newResponse()` method.

```php
class MyClass
{
    public function __construct()
    {
        $this->response = jaxon()->getResponse();
    }
}
```

By making many successive calls to Jaxon responses, a complex series of actions to be executed in the browser can be constructed in a simple way.

```php
class MyClass
{
    public function __construct()
    {
        $this->response = jaxon()->getResponse();
    }

    public function firstMethod()
    {
        // Call the response
        // $this->response->
    }

    public function secondMethod()
    {
        // Call the response
        // $this->response->

        $this->firstMethod();
    }

    public function thirdMethod()
    {
        // Call the response
        // $this->response->

        $this->firstMethod();
        $this->secondMethod();
    }
}
```
