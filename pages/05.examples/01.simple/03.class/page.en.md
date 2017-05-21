---
title: Hello World Class
menu: Hello World Class
template: jaxon
cache_enable: false
---

This example shows how to export a class with Jaxon.

#### How it works

Register the class [defined here](/examples/codes/class.html) with Jaxon.

```php
use Jaxon\Jaxon;

// Register object
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported class from javascript.

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
