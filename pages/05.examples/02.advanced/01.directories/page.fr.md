---
title: Exporter des classes dans des répertoires
menu: Exporter des répertoires
template: jaxon
cache_enable: false
---

Cet exemple montre comment exporter automatiquement toutes les classes présentes dans un ensemble de répertoires.

Lorsque les classes exportées d'un répertoire n'ont pas de namespace, elles doivent avoir des noms différents, même si elles ne sont pas dans le même sous-répertoire.

#### Comment ça marche

Exporter les classes dans les répertoires [définis ici](/examples/codes/directory.html) avec Jaxon.

```php
$jaxon = jaxon();

// Add class dirs
$jaxon->addClassDir('/jaxon/class/dir/app');
$jaxon->addClassDir('/jaxon/class/dir/ext');

// Register objects
$jaxon->registerClasses();

// Process the request, if any.
$jaxon->processRequest();
```

Appeler les classes exportées dans le code Javascript.

```php
<!-- Select -->
<select id="colorselect1" onchange="<?php echo rq()->call('Test.App.setColor', rq()->select('colorselect1')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>

<!-- Buttons -->
<button onclick="<?php echo rq()->call('Test.App.sayHello', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('Test.App.sayHello', 1) ?>">CLICK ME</button>
<button onclick="<?php echo rq()->call('Test.App.showDialog') ?>">Show Dialog</button>

<!-- Select -->
<select id="colorselect2" onchange="<?php echo rq()->call('Test.Ext.setColor', rq()->select('colorselect2')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>

<!-- Buttons -->
<button onclick="<?php echo rq()->call('Test.Ext.sayHello', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('Test.Ext.sayHello', 1) ?>">CLICK ME</button>
<button onclick="<?php echo rq()->call('Test.Ext.showDialog') ?>">Show Dialog</button>
```
