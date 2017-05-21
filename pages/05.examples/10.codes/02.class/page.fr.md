---
title: Classe Hello World
menu: Classe Hello World
template: jaxon
---

La classe peut être exportée, ou alors chaque méthode peut être exportée séparément.
Chaque méthode crée et retourne un objet `Response`.

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
