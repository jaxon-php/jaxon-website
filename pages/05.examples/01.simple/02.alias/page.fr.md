---
title: Alias Hello World
menu: Alias Hello World
template: jaxon
cache_enable: false
description: Cet exemple montre l'export des méthodes d'une classe comme des fonctions, à l'aide d'alias.
---

#### Comment ça marche

Définir la classe dont les méthodes doivent être exportées

```php
class HelloWorld
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';

        $xResponse = new Response();
        $xResponse->assign('div2', 'innerHTML', $text);

        return $xResponse;
    }

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);

        return $xResponse;
    }
}
```

Exported chaque méthode vers une fonction javascript

```php
$jaxon = jaxon();

// Register class methods as Jaxon functions
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, array('helloWorld', $hello, 'sayHello'));
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, 'setColor'));

// Process the request, if any.
$jaxon->processRequest();
```

Appeler la fonctions exportée dans le code Javascript

```php
// Select
<select id="colorselect" onchange="jaxon_setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="jaxon_helloWorld(0); return false;">Click Me</button>
<button onclick="jaxon_helloWorld(1); return false;">CLICK ME</button>
```
