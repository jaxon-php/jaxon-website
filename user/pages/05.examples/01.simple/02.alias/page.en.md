---
title: Hello World Alias
menu: Hello World Alias
template: jaxon
cache_enable: false
---

This example shows how to export the methods of a class as functions with Jaxon, using aliases.

#### How it works

Register the methods of the class [defined here](/examples/codes/class.html) with Jaxon.

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

Call the exported function from javascript.

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
