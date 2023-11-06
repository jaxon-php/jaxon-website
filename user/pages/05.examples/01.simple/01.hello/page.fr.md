---
title: Fonction Hello World
menu: Fonction Hello World
template: jaxon
cache_enable: false
---

Cet exemple montre l'export d'une fonction avec Jaxon.

#### Comment ça marche

Exporter les fonctions [définies ici](/examples/codes/function.html) avec Jaxon.

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register functions
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
$jaxon->register(Jaxon::USER_FUNCTION, 'setColor');

// Process the request, if any.
$jaxon->processRequest();
```

Appeler les fonctions exportées dans le code Javascript.

```php
<!-- Select -->
<select id="colorselect" onchange="<?php echo rq()->call('setColor', rq()->select('colorselect')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>
<!-- Buttons -->
<button onclick="<?php echo rq()->call('helloWorld', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('helloWorld', 1) ?>">CLICK ME</button>
```
