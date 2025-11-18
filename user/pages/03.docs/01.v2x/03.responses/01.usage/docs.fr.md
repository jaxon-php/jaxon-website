---
title: Créer et renvoyer une réponse
menu: Utilisation
template: jaxon
---

Une réponse Jaxon est un objet qui contient les actions à exécuter dans le navigateur en réponse à une requête Jaxon.
Toutes les fonctions appelées par Jaxon doivent par conséquent renvoyer un objet du type `Jaxon\Response\Response`.

Il existe par défaut dans la librairie une réponse Jaxon à laquelle on accède avec la méthode `Jaxon::getGlobalResponse()` dans la version 1, ou `Jaxon::getResponse()` à partir de la version 2.  
Il est toutefois possible d'en créer d'autres, en instanciant la classe `Jaxon\Response\Response`.

```php
use Jaxon\Response\Response;

class MyClass
{
    public function __construct()
    {
        $this->response = new Response;
    }

    public function firstMethod()
    {
        // Function body
        return $this->response;
    }

    public function secondMethod()
    {
        // Function body
        return $this->response;
    }
}
```

En appelant successivement plusieurs fonctions qui accèdent à une même instance de `Jaxon\Response\Response`, on peut construire de façon simple une série d'actions complexes à exécuter dans le navigateur.

```php
use Jaxon\Response\Response;

class MyClass
{
    public function __construct()
    {
        $this->response = new Response;
    }

    public function firstMethod()
    {
        // Function body
        return $this->response;
    }

    public function secondMethod()
    {
        // Function body
        $this->firstMethod();
        return $this->response;
    }

    public function thirdMethod()
    {
        // Function body
        $this->firstMethod();
        $this->secondMethod();
        return $this->response;
    }
}
```
