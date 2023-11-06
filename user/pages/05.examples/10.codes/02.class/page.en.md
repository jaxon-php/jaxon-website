---
title: Hello World Class
menu: Hello World Class
template: jaxon
---

The class can be registered, or else each method can be registered separately.
Each method creates and returns a `Response` object.

```php
class HelloWorld
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function sayHello($isCaps)
    {
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $this->response->assign('div2', 'innerHTML', $text);

        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div2', 'style.color', $sColor);

        return $this->response;
    }
}
```
