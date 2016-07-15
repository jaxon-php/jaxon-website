---
title: Exporting functions from PHP to Javascript
menu: PHP and Javascript
template: jaxon
---

The Jaxon library exports classes and functions from a PHP application to javascript, so they can be called directly from a webpage in a browser, using the Ajax technology.

```php
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

After the functions and classes are exported, the Jaxon library creates a corresponding javascript code that will be integrated into the web page.

```html
<button onclick="jaxon_helloworld('Jaxon')">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello('Jaxon')">Click Me</button>
```

When the javascript function is called in the browser, an Ajax request is automatically created and sent to the server with the parameters passed to the function. The Jaxon library receives the request, and calls the PHP function with the received parameters.  
All these operations are completely managed by Jaxon, and transparent to the developer.
