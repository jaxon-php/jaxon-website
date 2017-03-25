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

Definir la classe à exporter

```php
class HelloWorld
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';

        $xResponse = new Response();
        $xResponse->assign('div2', 'innerHTML', $text);

        return $xResponse;
    }

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);

        return $xResponse;
    }
}
```

Exporter la classe avec Jaxon, et définir les options générer le code dans un fichier externe

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

Appeler la classe exportée dans le code Javascript

```php
// Select
<select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="JaxonHelloWorld.sayHello(0); return false;">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello(1); return false;">CLICK ME</button>
```
