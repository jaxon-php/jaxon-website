---
title: Create and return a response
menu: Usage
template: docs
---

An Jaxon response is an object that encapsulates the commands to be executed in the browser in response to an Jaxon request.
All functions called by Jaxon should therefore return an object of type `Jaxon\Response\Response`.

By default there is a response in the library Jaxon which is accessed with the `Jaxon::getGlobalResponse()` method.
However, it is possible to create others, by instantiating the `Jaxon\Response\Response` class.
```php
use Jaxon\Response\Response;

class MyClass
{
    public function __construct()
    {
        $this->response = new Response;
    }

    public function first_method()
    {
        // Function body
        return $this->response;
    }

    public function second_method()
    {
        // Function body
        return $this->response;
    }
}
```

By calling successively several functions that access the same instance of  `Jaxon\Response\Response`, a complex series of actions to be executed in the browser can be constructed in a simple way.
```php
use Jaxon\Response\Response;

class MyClass
{
    public function __construct()
    {
        $this->response = new Response;
    }

    public function first_method()
    {
        // Function body
        return $this->response;
    }

    public function second_method()
    {
        // Function body
        $this->first_method();
        return $this->response;
    }

    public function third_method()
    {
        // Function body
        $this->first_method();
        $this->second_method();
        return $this->response;
    }
}
```
