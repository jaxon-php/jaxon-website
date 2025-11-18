---
title: Un exemple simple
menu: Un exemple simple
template: jaxon
---

Voici la traditionnelle application `Hello World` avec Jaxon.  
Pour plus de clarté, tout le code est d'abord placé dans un seul fichier.
Il est ensuite séparé en 3 fichiers, pour illustrer les différentes phases du fonctionnement de la librairie.

D'abord, la classe `HelloWorld` est définie. Elle contient une méthode `sayHello()` qui renvoie un objet `Jaxon\Response\Response`.
L'appel `$response->alert($text)` sert à afficher un message dans la page web.

Ensuite, une instance de la classe est enregistrée dans la librairie Jaxon.  
L'appel `$jaxon->processRequest()` vérifie si une requête à Jaxon est présente dans les paramètres HTTP, auquel cas elle la traite et renvoie le résultat.
Sinon, le traitement continue avec l'affichage de la page HTML.

Les appels à `$jaxon->getCss()`, `$jaxon->getJs()` et `$jaxon->getScript()` affichent le code généré par Jaxon dans la page.
L'appel à `JaxonHelloWorld.sayHello(1)` va invoquer la méthode `sayHello()` de la classe PHP `HelloWord`, qui va à son tour afficher un message dans la page web.

```php
<?php 
use Jaxon\Response\Response;

// La classe HelloWorld
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

// Retrouver le singleton Jaxon
$jaxon = jaxon();

// Enregistrer une instance de la classe avec Jaxon
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Traiter la requête Jaxon, lorsqu'il y en a une
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

#### Séparation en plusieurs fichiers

L'exemple ci-dessus peut être amélioré en séparant le code dans 3 fichiers distincts.

##### 1. La déclaration des classes

Ce fichier contient les classes et fonctions à appeler avec Jaxon, ainsi que les instructions pour les exporter.
Il définit également les paramètres de configuration de la librairie.

```php
<?php
// File defs.php

use Jaxon\Response\Response;

// La classe HelloWorld
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

// Retrouver le singleton Jaxon
$jaxon = jaxon();

// Définir l'URI de traitement de la requête Jaxon
$jaxon->setOption('core.request.uri', 'ajax.php');

// Enregistrer une instance de la classe avec Jaxon
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```

##### 2. Le traitement des requêtes

Ce fichier traite les requêtes Jaxon.
Il inclut le fichier de déclaration, afin de pouvoir appeler les classes et fonctions exportées.

```php
<?php
// File ajax.php

require __DIR__ . '/defs.php';

// Retrouver le singleton Jaxon
$jaxon = jaxon();

// Call the Jaxon processing engine
if($jaxon->canProcessRequest())
    $jaxon->processRequest();
}
```

##### 3. L'affichage de la page

Ce fichier affiche la page à partir de laquelle les classes et fonctions Jaxon vont être appelées.
Il inclut le fichier de déclaration des classes, afin que Jaxon puisse générer le code javascript et CSS correspondant aux classes et fonctions exportées.

```php
<?php
// File page.php

require __DIR__ . '/defs.php';

// Retrouver le singleton Jaxon
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
