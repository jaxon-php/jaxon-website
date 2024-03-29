---
title: Extern Javascript file
menu: Javascript file
template: jaxon
cache_enable: false
---

This example shows how to save the generated javascript code in an external file.

By default, the javascript code generated by Jaxon is inserted in the HTML code of the page.
However, the library can be configured to save the code in an external file, and then generate the code to load this file into the page.
In this case, the library shall be provided with an existing directory, and the URI that gives access to this directory from a browser.

#### How it works

Register the class [defined here](/examples/codes/class.html) with Jaxon, and set the options to generate code in an extern file.

```php
use Jaxon\Jaxon;

$jaxon = jaxon();

$jaxonAppURI = '/jaxon/app';
$jaxonAppDir = __DIR__ . '/jaxon/app';

$this->setOption('js.app.extern', true);
$this->setOption('js.app.dir', $jaxonAppDir);
$this->setOption('js.app.uri', $jaxonAppURI);
$this->setOption('js.app.minify', true); // Optionally, the file can be minified

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
```
