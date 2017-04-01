---
title: Un exemple simple
menu: Un exemple simple
template: jaxon
---

Voici la traditionnelle application `Hello World` avec Jaxon.

D'abord, la classe `HelloWorld` est définie. Elle contient une méthode `sayHello()` qui renvoie un objet `Jaxon\Response\Response`.
L'instruction `$response->alert($text)` sert à afficher un message dans la page web.

Ensuite, une instance de la classe est enregistrée dans la librairie Jaxon.  
L'instruction `$jaxon->processRequest()` vérifie si une requête à Jaxon est présente dans les paramètres HTTP, auquel cas elle la traite et renvoie le résultat.
Sinon, le traitement continue avec l'affichage de la page HTML.

Les appels à `$jaxon->getCss()`, `$jaxon->getJs()` et `$jaxon->getScript()` affichent le code généré par Jaxon dans la page.
L'appel à `JaxonHelloWorld.sayHello(1)` va invoquer la méthode `sayHello()` de la classe PHP `HelloWord`, qui va à son tour afficher un message dans la page web.

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
