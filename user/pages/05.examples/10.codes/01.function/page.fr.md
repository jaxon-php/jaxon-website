---
title: Fonction Hello World
menu: Fonction Hello World
template: jaxon
---

Voici les fonctions à exporter avec Jaxon.
Chaque fonction crée et retourne un objet `Response`.

```php
function helloWorld($isCaps)
{
    $response = new Response();

    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div1', 'innerHTML', $text);

    return $response;
}

function setColor($sColor)
{
    $response = new Response();

    $response->assign('div1', 'style.color', $sColor);

    return $response;
}
```
