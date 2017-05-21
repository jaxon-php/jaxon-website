---
title: Register Classes in Directories
menu: Register Directories
template: jaxon
cache_enable: false
---

This example shows how to automatically register all the classes in a set of directories.

When classes registered from a directory are not namespaced, they all need to have different names, even if they are in different subdirs.

#### How it works

Register the classes in the directories [defined here](/examples/codes/directory.html) with Jaxon.

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

Call the exported classes from javascript.

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
