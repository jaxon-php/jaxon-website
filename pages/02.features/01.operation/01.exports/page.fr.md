---
title: Exporter des fonctions de PHP vers Javascript
menu: PHP et Javascript
template: jaxon
---

La librairie Jaxon exporte des classes et des fonctions d'une application PHP vers javascript, de façon à pouvoir les appeler directement depuis une page web dans un navigateur, grâce à Ajax.

```php
use Jaxon\Jaxon;

function helloworld($name) 
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

Lorsque les classes et les fonctions sont exportées, la librarie Jaxon crée le code javascript correspondant, qui sera intégré à la page web.

```html
<button onclick="jaxon_helloworld('Jaxon')">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello('Jaxon')">Click Me</button>
```

Lorsqu'une fonction javascript est appelée dans le navigateur, une requête Ajax est automatiquement créée et envoyée vers le serveur avec les paramètres de la fonction. La librairie Jaxon reçoit cette requête, et appelle la fonction PHP avec les paramètres reçus.  
Cette partie est entièrement gérée par Jaxon, et transparente pour le développeur.
