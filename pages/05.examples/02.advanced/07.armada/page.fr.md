---
title: Jaxon Armada
menu: Armada
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation de [Jaxon Armada](/docs/armada/operation.html).

L'application démarre à partir de [ce fichier de configuration](https://github.com/jaxon-php/jaxon-examples/tree/master/armada/config/jaxon.php).
Les classes de l'application sont [définies ici](/examples/codes/armada-classes.html), et les vues de l'application sont [définies ici](/examples/codes/armada-views.html).
Elles se trouvent toutes dans les répertoires indiqués dans la configuration.

#### Comment ça marche

Installer Armada et au moins un [package de vues](/docs/armada/views.html) avec `Composer`.

```json
"require": {
    "jaxon-php/jaxon-armada": "2.0.*",
    "jaxon-php/jaxon-twig": "2.0.*"
}
```

Démarrer l'application avec le fichier de configuration ci-dessus.

```php
$armada = jaxon()->armada();
$armada->config('/path/to/config.php');

if($armada->canProcessRequest())
{
    // Process the request
    $armada->processRequest();
}
else
{
    // Register the classes
    $armada->register();
}
```

Appeler les classes exportées dans le code Javascript, en utilisant l'API fluide fournie par Armada.

```php
<!-- Select -->
<select id="colorselect1" onchange="<?php echo rq('Jaxon.App.Test.Pgw')->setColor(rq()->select('colorselect1')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>

<!-- Buttons -->
<button onclick="<?php echo rq('Jaxon.App.Test.Pgw')->sayHello(0) ?>">Click Me</button>
<button onclick="<?php echo rq('Jaxon.App.Test.Pgw')->sayHello(1) ?>">CLICK ME</button>
<button onclick="<?php echo rq('Jaxon.App.Test.Pgw')->showDialog() ?>">Show Dialog</button>

<!-- Select -->
<select id="colorselect2" onchange="<?php echo rq('Jaxon.App.Test.Bts')->setColor(rq()->select('colorselect2')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>

<!-- Buttons -->
<button onclick="<?php echo rq('Jaxon.App.Test.Bts')->sayHello(0) ?>">Click Me</button>
<button onclick="<?php echo rq('Jaxon.App.Test.Bts')->sayHello(1) ?>">CLICK ME</button>
<button onclick="<?php echo rq('Jaxon.App.Test.Bts')->showDialog() ?>">Show Dialog</button>
```
