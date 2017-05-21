---
title: Register Classes in Namespaces
menu: Register Namespaces
template: jaxon
cache_enable: false
---

This example shows how to automatically register all the classes in a set of directories with namespaces.

The namespace name is prepended to the generated javascript class names, and PHP classes in different subdirs can have the same name.

#### How it works

Register the classes in the namespaces [defined here](/examples/codes/namespace.html) with Jaxon.

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

Call the exported classes from javascript.

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
