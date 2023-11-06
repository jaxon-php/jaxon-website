---
title: Jaxon Armada
menu: Armada
template: jaxon
cache_enable: false
---

This example shows the usage of the [Jaxon Armada](/docs/armada/operation.html).

The application bootstraps from [this config file](https://github.com/jaxon-php/jaxon-examples/tree/master/armada/config/jaxon.php).
The classes of the application are [defined here](/examples/codes/armada-classes.html), and the views of the application are [defined here](/examples/codes/armada-views.html).
The are all found in the directories specified in the configuration.

#### How it works

Install Armada and at least one [view package](/docs/armada/views.html) with `Composer`.

```json
"require": {
    "jaxon-php/jaxon-armada": "2.0.*",
    "jaxon-php/jaxon-twig": "2.0.*"
}
```

Bootstrap the application with the above configuration file, using the fluent API provided by Armada.

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

Call the exported classes from javascript.

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
