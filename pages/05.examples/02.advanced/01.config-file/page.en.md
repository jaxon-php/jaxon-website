---
title: Config File
menu: Config File
template: jaxon
cache_enable: false
description: In this example, the config options of the Jaxon library and its plugins are loaded from a file in Yaml format.
---

<div class="row" markdown="1">
When loading settings from a file, a second parameter can be passed to the `readConfigFile()` call to make the library load the options from a particular section of the file.
In this example, the config options are under the `jaxon` section of the file.
</div>

<div class="row" markdown="1">
The class which is registered in this example is the same as in the [Response plugin](../../simple/plugins) example.
</div>

<div class="row">
    <h5>How it works</h5>

<p>1. Write the configuration options in a Yaml file</p>
<pre><code class="language-yaml">
jaxon:
  core:
    debug:
      on:                       true
    prefix:
      class:                    "Jaxon"
  
  toastr:
    options:
      closeButton:              true
      closeMethod:              "fadeOut"
      closeDuration:            300
      closeEasing:              "swing"
      positionClass:            "toast-bottom-left"
  
  pgw:
    assets:
      include:                  true
    modal:
      options:
        closeOnEscape:          true
        closeOnBackgroundClick: true
        maxWidth:               600
</code></pre>

<p>2. Read the configuration options from the file</p>

<pre><code class="language-php">
// Register object
$jaxon = Jaxon::getInstance();

$jaxon->readConfigFile(__DIR__ . '/config/config.yaml', 'jaxon');

$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

</div>
