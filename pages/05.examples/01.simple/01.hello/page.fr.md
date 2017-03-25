---
title: Fonction Hello World
menu: Fonction Hello World
template: jaxon
cache_enable: false
---

Cet exemple montre l'export d'une fonction avec Jaxon.

#### Comment ça marche

Definir les fonctions à exporter

```php
function helloWorld($isCaps)
{
    if ($isCaps)
        $text = 'HELLO WORLD!';
    else
        $text = 'Hello World!';

    $xResponse = new Response();
    $xResponse->assign('div1', 'innerHTML', $text);

    return $xResponse;
}

function setColor($sColor)
{
    $xResponse = new Response();
    $xResponse->assign('div1', 'style.color', $sColor);

    return $xResponse;
}
```

Exporter les fonctions avec Jaxon

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register functions
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
$jaxon->register(Jaxon::USER_FUNCTION, 'setColor');

// Process the request, if any.
$jaxon->processRequest();
```

Appeler les fonctions exportées dans le code Javascript

```php
// Select
<select id="colorselect" onchange="jaxon_setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="jaxon_helloWorld(0); return false;">Click Me</button>
<button onclick="jaxon_helloWorld(1); return false;">CLICK ME</button>
```
