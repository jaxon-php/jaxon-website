---
title: Fichier de configuration
menu: Fichier de configuration
template: jaxon
cache_enable: false
---

Dans cet exemple, la configuration de la librairie Jaxon et de ses plugins est lue dans un fichier au format Yaml.
Les options de configuration se trouvent dans la section `jaxon` du fichier.

#### Comment ça marche

&Eacute;crire les options de configuration [définies ici](/examples/codes/plugin.html) dans un fichier, et le charger avec la méthode `readConfigFile()`.

```php
use Jaxon\Jaxon;

// Register object
$jaxon = jaxon();

$jaxon->readConfigFile(__DIR__ . '/config/config.yaml', 'jaxon');

$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
```
