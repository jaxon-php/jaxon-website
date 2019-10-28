---
title: A simple example
menu: A simple example
template: jaxon
---

Here is the well known `Hello World` application with Jaxon.
For the sake of clarity, all the code is first included in a single file.
It is then separated into 3 files, to further illustrate the various phases of the library operation.

First, the `HelloWorld` class is defined. It implements a `sayHello()` method which returns an instance of `Jaxon\Response\Response`.
The call to `$response->alert($text)` will print an alert message in the webpage.

Then, an instance of the `HelloWorld` class is registered with the Jaxon library.
The call to `$jaxon->processRequest()` checks if a request to Jaxon is available in the HTTP parameters, in which case it is processed and the result is returned to the webpage.
If there is no request, the HTML code is printed.

The calls to `$jaxon->getCss()`, `$jaxon->getJs()` and `$jaxon->getScript()` print the Jaxon generated code in the webpage.
The call to `JaxonHelloWorld.sayHello(1)` will invoke the method `sayHello()` in the PHP class `HelloWord`, which will print an alert message into the webpage.

```php
<?php
use Jaxon\Response\Response;

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

// Register an instance of the class with Jaxon
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);

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

#### Separating into multiple files

The above example can be enhanced by separating the code into three files.

##### 1. Declaring classes and functions

This file defines classes and functions to be called with Jaxon, as well as instructions to export them.
It also defines the library configuration options.

```php
<?php
// File defs.php

use Jaxon\Response\Response;

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

// Get the Jaxon singleton object
$jaxon = jaxon();

// Set the Jaxon request processing URI
$jaxon->setOption('core.request.uri', 'ajax.php');

// Register an instance of the class with Jaxon
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```

##### 2. Processing requests

This file processes Jaxon requests.
It includes the declaration file, in order to be able to call exported classes and functions.

```php
<?php
// File ajax.php

require __DIR__ . '/defs.php';

// Get the Jaxon singleton object
$jaxon = jaxon();

// Call the Jaxon processing engine
if($jaxon->canProcessRequest())
    $jaxon->processRequest();
}
```

##### 3. Printing the page

This file prints the page from which the Jaxon classes and functions are going to be called.
It includes the declaration file, so Jaxon can generate the javascript and CSS code corresponding to the exported classes and functions.

```php
<?php
// File page.php

require __DIR__ . '/defs.php';

// Get the Jaxon singleton object
$jaxon = jaxon();
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
