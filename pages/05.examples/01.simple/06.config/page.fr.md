---
title: Fichier de configuration
menu: Fichier de configuration
template: jaxon
cache_enable: false
description: Dans cet exemple, la configuration de la librairie Jaxon et de ses plugins est lue dans un fichier au format Yaml.
---

Lorsque la configuration est lue dans un fichier, un second paramètre peut être passé à l'appel à `readConfigFile()` pour indiquer la section du fichier qui comprend les options. 
Dans cet exemple, les options de configuration se trouvent dans la section `jaxon` du fichier.
La classe exportée dans cet exemple est la même que celle de l'exemple [Plugin de réponse](../../simple/plugins).

#### Comment ça marche

&Eacute;crire les paramètres de configuration dans un fichier Yaml

```yaml
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
```

Lire les options de configuration dans le fichier

```php
use Jaxon\Jaxon;

// Register object
$jaxon = jaxon();

$jaxon->readConfigFile(__DIR__ . '/config/config.yaml', 'jaxon');

$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```
