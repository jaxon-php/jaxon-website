---
title: Config File
menu: Config File
template: jaxon
cache_enable: false
description: Dans cet exemple, la configuration de la librairie Jaxon et de ses plugins est lue dans un fichier au format Yaml.
---

<div class="row" markdown="1">
Lorsque la configuration est lue dans un fichier, un second paramètre peut être passé à l'appel à `readConfigFile()` pour indiquer la section du fichier qui comprend les options. 
Dans cet exemple, les options de configuration se trouvent dans la section `jaxon` du fichier.
</div>

<div class="row" markdown="1">
La classe exportée dans cet exemple est la même que celle de l'exemple [Plugin de réponse](../../simple/plugins).
</div>

<div class="row">
    <h5>Comment ça marche</h5>

<p>1. &Eacute;crire les paramètres de configuration dans un fichier Yaml</p>
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

<p>2. Lire les options de configuration dans le fichier</p>
<pre><code class="language-php">
// Register object
$jaxon = Jaxon::getInstance();

$jaxon->readConfigFile(__DIR__ . '/config/config.yaml', 'jaxon');

$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

</div>
