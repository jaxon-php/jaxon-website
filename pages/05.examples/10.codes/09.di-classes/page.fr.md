---
title: Classe avec injection de dépendance
menu: Classe avec DI
template: jaxon
---

L'injection de dépendance permet d'ajouter des classes ou des interfaces en paramètres du constructeur des classes Jaxon.

```php
use Service\ExampleInterface;

class HelloWorld
{
    protected $service;
    protected $response;

    public function __construct(ExampleInterface $service)
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
