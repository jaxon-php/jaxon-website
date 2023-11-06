---
title: Hello World Function
menu: Hello World Function
template: jaxon
cache_enable: false
---

This example shows how to export a function with Jaxon.

#### How it works

Register the functions [defined here](/examples/codes/function.html) with Jaxon.

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register functions
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
$jaxon->register(Jaxon::USER_FUNCTION, 'setColor');

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported functions from javascript.

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
