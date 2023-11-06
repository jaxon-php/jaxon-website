---
title: Config File
menu: Config File
template: jaxon
cache_enable: false
---

In this example, the config options of the Jaxon library and its plugins are loaded from a file in Yaml format.
The config options are under the `jaxon` section of the file.

#### How it works

Copy the configuration options [defined here](/examples/codes/plugin.html) in a file, which is then loaded with the `readConfigFile()` method.

```php
// Register object
use Jaxon\Jaxon;

$jaxon = jaxon();

$jaxon->readConfigFile(__DIR__ . '/config/config.yaml', 'jaxon');

$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```
