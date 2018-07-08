---
title: Class with dependency injection
menu: Class with DI
template: jaxon
---

With dependency injection, classes and interfaces can be added as parameters in the constructor of Jaxon classes.

```php
use Service\IExample;

class HelloWorld
{
    protected $service;
    protected $response;

    public function __construct(IExample $service)
    {
        $this->service = $service;
        $this->response = new Response();
    }

    public function sayHello($isCaps)
    {
        $text = $this->service->message($isCaps);
        $this->response->assign('div2', 'innerHTML', $text);
        return $this->response;
    }

    public function setColor($sColor)
    {
        $sColor = $this->service->color($sColor);
        $this->response->assign('div2', 'style.color', $sColor);
        return $this->response;
    }
}
```
