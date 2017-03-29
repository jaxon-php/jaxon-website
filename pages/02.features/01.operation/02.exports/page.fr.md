---
title: Exporter des classes et fonctions de PHP vers Javascript
menu: PHP et Javascript
template: jaxon
---

La librairie Jaxon exporte des classes et des fonctions d'une application PHP vers javascript, de façon à pouvoir les appeler directement depuis une page web dans un navigateur, grâce à Ajax.
Lorsqu'une classe PHP est exportée, une classe javascript du même nom (avec un préfixe [configurable](/docs/usage/configuration)) est automatiquement créée et incluse dans la page web.

Lorsque la classe javascript est appelée dans le navigateur, une requête Ajax est automatiquement créée et envoyée vers le serveur avec les paramètres de la fonction.
La librairie Jaxon reçoit cette requête, et appelle la classe PHP avec les paramètres reçus.  

Dans l'exemple ci-dessous, une classe et une fonction sont exportées avec Jaxon, et appelées dans un formulaire.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;

function helloWorld($name) 
{ 
    $response = new Response();          // Instance the response class 
    $response->alert("Hello $name");     // Invoke the alert method
    return $response;                    // Return the response to the browser
}  

class HelloWorld
{
    public function sayHello($name)
    {
        $response = new Response();      // Instance the response class 
        $response->alert("Hello $name"); // Invoke the alert method
        return $response;                // Return the response to the browser
    }
}

// Get the main Jaxon object
$jaxon = jaxon();
// Register a function with Jaxon
$jaxon->register(Jaxon::USER_FUNCTION, 'helloworld');
// Register an object with Jaxon
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld);
```

Un click sur les boutons HTML ci-dessous va afficher le message `Hello Jaxon` dans la page.

```html
<button onclick="jaxon_helloWorld('Jaxon')">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello('Jaxon')">Click Me</button>
```
