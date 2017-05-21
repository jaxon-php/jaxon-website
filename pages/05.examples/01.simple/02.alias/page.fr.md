---
title: Alias Hello World
menu: Alias Hello World
template: jaxon
cache_enable: false
---

Cet exemple montre l'export des méthodes d'une classe comme des fonctions, à l'aide d'alias.

#### Comment ça marche

Exporter les méthodes de la classe [définie ici](/examples/codes/class.html) avec Jaxon.

```php
use Jaxon\Jaxon;

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
