---
title: Utiliser l'objet Response
menu: Réponses
template: jaxon
---

Une réponse Jaxon fournit [les fonctions pour générer les actions](../../features/responses.html) à exécuter dans le navigateur en réponse à une requête Jaxon.

Il existe par défaut dans la librairie une réponse Jaxon à laquelle on accède avec la méthode `jaxon()->getResponse()`.
Il est toutefois possible d'en créer d'autres, en appelant la méthode `jaxon()->newResponse()`.

```php
class MyClass
{
    public function __construct()
    {
        $this->response = jaxon()->getResponse();
    }
}
```

En faisant plusieurs appels successifs à des réponses Jaxon, on peut construire de façon simple une série d'actions complexes à exécuter dans le navigateur.

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
