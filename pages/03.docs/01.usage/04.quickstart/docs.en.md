---
title: A simple example
menu: A simple example
template: jaxon
---

Here is the traditional `Hello World` application with Jaxon.

First, the `HelloWorld` class is defined. It implements a `sayHello()` method which returns an instance of `Jaxon\Response\Response`.
The instruction `$response->alert($text)` will print an alert message in the webpage.

Then, an instance of the `HelloWorld` class is registered with the Jaxon library.  
The instruction `$jaxon->processRequest()` checks if a request to Jaxon is available in the HTTP parameters, in which case it is processed and the result is returned to the webpage.
If there is no request, the HTML code is printed.

The calls to `$jaxon->getCss()`, `$jaxon->getJs()` and `$jaxon->getScript()` print the Jaxon generated code in the webpage.
The call to `JaxonHelloWorld.sayHello(1)` will invoke the method `sayHello()` in the PHP class `HelloWord`, which will print an alert message into the webpage.

```php
<?php 
use Jaxon\Response\Response;             // The Response class

// The HelloWorld class
class HelloWorld
{
    public function sayHello($isCaps)
    {
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response = new Response();
        $response->alert($text);
        return $response;
    }
}

// Get the core singleton object
$jaxon = jaxon();
// Register the function with Jaxon
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
// Call the Jaxon processing engine
$jaxon->processRequest();

?>
<!doctype html>
<html>
<head>
    <title>Jaxon Simple Test</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/favicon.ico">
<?php
// Insert the Jaxon CSS code into the page
echo $jaxon->getCss();
?>    
</head>
<body>
    <input type="button" value="Submit" onclick="JaxonHelloWorld.sayHello(1);return false;" />
</body>
<?php
// Insert the Jaxon javascript code into the page
echo $jaxon->getJs();
echo $jaxon->getScript();
?>    
</html>
```
