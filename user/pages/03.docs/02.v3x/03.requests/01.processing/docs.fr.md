---
title: Traiter les requêtes Jaxon
menu: Traiter les requêtes
template: jaxon
---

Quelque soit le nombre de classes PHP qu'elle exporte vers javascript, une application qui utilise la librairie Jaxon a besoin d'un seul point d'entrée pour toutes les requêtes Ajax vers ces classes.

Le code le plus simple pour traiter une requête vers une classe Jaxon est le suivant:

```php
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);

if($jaxon->canProcessRequest())
{
    $jaxon->processRequest();
}
```

La méthode `processRequest()` appelle la fonction ou la classe indiquée dans la requête et renvoie la réponse retournée au client.

#### Un exemple plus complet

Dans l'exemple suivant, le code va être organisé dans plusieurs fichiers, pour donner un exemple plus complet de l'utilisation de Jaxon.

##### 1. La déclaration des classes

Ce fichier contient une classe à appeler avec Jaxon.
Il peut y en avoir plusieurs ainsi dans l'application.

```php
// File HelloWorld.php

use Jaxon\Response\Response;

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
```

##### 2. L'initialisation de la librairie

Ce fichier définit les options de configuration de la librairie.

```php
// File setup.php

$jaxon = jaxon();

$jaxon->setOption('core.request.uri', 'ajax.php');

$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, ['include' => __DIR__ . '/HelloWorld.php']);
```

Le troisième paramètre de l'appel sert à retrouver la classe `HelloWorld`.
Il est optionnel et n'est pas requis si un autre moyen existe dans l'application pour retrouver la classe, par exemple l'autoloading.

##### 3. La génération du code javascript

Les codes javascript et CSS générés par Jaxon doivent être insérés dans le code HTML de la page à afficher dans le navigateur.

Rappelons qu'ils sont obtenus par les appels à `$jaxon->getCss()`, `$jaxon->getJs()` et `$jaxon->getScript()`.

```php
$jaxon = jaxon();

$jaxonCss = $jaxon->getCss();
$jaxonJs = $jaxon->getJs();
$jaxonScript = $jaxon->getScript();
```

Ils doivent ensuite être insérés dans le code HTML de la page, comme dans l'exemple suivant.

```php
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

<?= $jaxonCss ?>

</head>
<body>
    <input type="button" value="Submit" onclick="JaxonHelloWorld.sayHello(1);return false;" />
</body>

<?= $jaxonJs ?>

<?= $jaxonScript ?>

</html>
```

##### 4. Le traitement des requêtes

Ce fichier traite les requêtes Jaxon.

```php
<?php
// File ajax.php

require __DIR__ . '/setup.php';

$jaxon = jaxon();

if($jaxon->canProcessRequest())
{
    $jaxon->processRequest();
}
```
