---
title: Exporter des classes dans des namespaces
menu: Exporter des namespaces
template: jaxon
cache_enable: false
---

Cet exemple montre comment exporter automatiquement toutes les classes présentes dans un ensemble de répertoires avec des namespaces.

Le nom des classes javascript générées est préfixé avec le namespace, et des classes PHP dans des sous-répertoires différents peuvent avoir le même nom.

#### Comment ça marche

Exporter les classes dans les namespaces [définis ici](/examples/codes/namespace.html) avec Jaxon.

```php
$jaxon = jaxon();

// Add class dirs with namespaces
$jaxon->addClassDir('/jaxon/class/dir/app', 'App');
$jaxon->addClassDir('/jaxon/class/dir/ext', 'Ext');

// Register objects
$jaxon->registerClasses();

// Process the request, if any.
$jaxon->processRequest();
```

Appeler les classes exportées dans le code Javascript.

```php
<!-- Select -->
<select id="colorselect" onchange="<?php echo rq()->call('App.Test.Test.setColor', rq()->select('colorselect1')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>

<!-- Buttons -->
<button onclick="<?php echo rq()->call('App.Test.Test.sayHello', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('App.Test.Test.sayHello', 1) ?>">CLICK ME</button>
<button onclick="<?php echo rq()->call('App.Test.Test.showDialog') ?>">Show Dialog</button>

<!-- Select -->
<select id="colorselect" onchange="<?php echo rq()->call('Ext.Test.Test.setColor', rq()->select('colorselect2')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>

<!-- Buttons -->
<button onclick="<?php echo rq()->call('Ext.Test.Test.sayHello', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('Ext.Test.Test.sayHello', 1) ?>">CLICK ME</button>
<button onclick="<?php echo rq()->call('Ext.Test.Test.showDialog') ?>">Show Dialog</button>
```
