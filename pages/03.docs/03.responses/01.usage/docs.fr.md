---
title: Créer et renvoyer une réponse
menu: Créer et renvoyer une réponse
template: docs
---

Une réponse Jaxon est un objet qui encapsule les actions à exécuter dans le navigateur en réponse à une requête Jaxon.
Toutes les fonctions appelées par Jaxon doivent par conséquent renvoyer un objet du type `Jaxon\Response\Response`.

Il existe par défaut dans la librairie une réponse Jaxon à laquelle on accède avec la méthode `Jaxon::getGlobalResponse()`.
Il est toutefois possible d'en créer d'autres, en instanciant la classe `Jaxon\Response\Response`.
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

En appelant successivement plusieurs fonctions qui accèdent à une même instance de  `Jaxon\Response\Response`, on peut construire de façon simple une série d'actions complexes à exécuter dans le navigateur.
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
