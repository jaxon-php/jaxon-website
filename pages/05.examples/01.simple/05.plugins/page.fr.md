---
title: Plugin de réponse
menu: Plugin de réponse
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation des plugins de réponse de Jaxon, en ajoutant des notifications et des fenêtres modales à l'exemple Classe Hello World avec le plugin jaxon-bootbox.

L'utilisation d'un plugin de réponse est très simple. Après son installation, le plugin s'enregistre automatiquement dans la librairie Jaxon. Il devient alors accessible depuis la classe Response de Jaxon, pour fournir ses fonctions à l'application.

#### Comment ça marche

Installer le plugin Dialog avec `Composer`.

```json
"require": {
    "jaxon-php/jaxon-dialogs": "2.0.*"
}
```

Exporter la classe [définie ici](/examples/codes/plugin.html) avec Jaxon.
Cette classe utilise le plugin Dialog pour afficher des notifications et une fenêtre modale.

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register object
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
<button onclick="<?php echo rq()->call('HelloWorld.showDialog') ?>">Show Dialog</button>
```
