---
title: Fichier Javascript externe
menu: Fichier Javascript
template: jaxon
cache_enable: false
---

Cet exemple montre comment enregistrer le code javascript généré par la librairie dans un fichier externe.

Par défaut, le code javascript généré par Jaxon est inséré directement dans le code HTML de la page.
Cependant, la librairie peut être configurée pour enregistrer le code généré dans un fichier, et le charger depuis le code HTML de la page.
Pour ce faire, il faut passer à la librairie un répertoire existant, et l'URI qui donne accès à ce répertoire depuis un navigateur.

#### Comment ça marche

Exporter la classe [définie ici](/examples/codes/class.html) avec Jaxon, et définir les options générer le code dans un fichier externe.

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

Appeler la classe exportée dans le code Javascript.

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
