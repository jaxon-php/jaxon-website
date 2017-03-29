---
title: Exporting classes and functions from PHP to Javascript
menu: PHP and Javascript
template: jaxon
---

The Jaxon library exports classes and functions from a PHP application to javascript, so they can be called directly from a webpage in a browser, using Ajax.
When a PHP class is exported, a javascript class with the same name (and a [configurable](/docs/usage/configuration) prefix) is created and included in the webpage.

When the javascript class is called in the browser, an Ajax request is automatically created and sent to the server with the parameters passed to the function.
The Jaxon library receives the request, and calls the PHP function with the received parameters.  

In the example below, a class and a function are exported with Jaxon, and called in a form.

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

A click on the HTML buttons below will print the message `Hello Jaxon` in the page.

```html
<button onclick="jaxon_helloWorld('Jaxon')">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello('Jaxon')">Click Me</button>
```
