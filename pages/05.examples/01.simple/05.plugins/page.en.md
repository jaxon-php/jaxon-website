---
title: Response Plugin
menu: Response Plugin
template: jaxon
cache_enable: false
---

This example shows the use of Jaxon response plugins, by adding javascript notifications and modal windows to the Hello World Class example with the jaxon-bootbox plugin.

Using a Jaxon plugin is very simple. After a plugin is installed with Composer, its automatically registers into the Jaxon core library. It can then be accessed in the Jaxon response object, to provide its functionalities to the application.

#### How it works

Install the Dialog plugin with `Composer`.

```json
"require": {
    "jaxon-php/jaxon-dialogs": "2.0.*"
}
```

Register the class [defined here](/examples/codes/plugin.html) with Jaxon.
This class uses the Dialog plugin to show notifications and a modal window.

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

// Register object
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported classe from javascript.

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
