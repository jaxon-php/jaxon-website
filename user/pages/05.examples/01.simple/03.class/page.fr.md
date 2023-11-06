---
title: Classe Hello World
menu: Classe Hello World
template: jaxon
cache_enable: false
---

Cet exemple montre l'export d'une classe avec Jaxon.

#### Comment ça marche

Exporter la classe [définie ici](/examples/codes/class.html) avec Jaxon.

```php
use Jaxon\Jaxon;

// Register object
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```

Appeler la classe exportée dans le code Javascript.

```php
<!-- Select -->
<select id="colorselect" onchange="<?php echo rq()->call('HelloWorld.setColor', rq()->select('colorselect')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>
<!-- Buttons -->
<button onclick="<?php echo rq()->call('HelloWorld.sayHello', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('HelloWorld.sayHello', 1) ?>">CLICK ME</button>
```
