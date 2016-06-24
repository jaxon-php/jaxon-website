---
title: Export Javascript
menu: Export Javascript
template: examples
cache_enable: false
description: Cet exemple montre comment enregistrer le code javascript généré par la librairie dans un fichier externe.
---

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">&nbsp;</h4>
Par défaut, le code javascript généré par Jaxon est inséré directement dans le code HTML de la page.
Cependant, la librairie peut être configurée pour enregistrer le code généré dans un fichier, et le charger depuis le code HTML de la page.
Pour ce faire, il faut passer à la librairie un répertoire existant, et l'URI qui donne accès à ce répertoire depuis un navigateur.
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">Comment ça marche</h4>

<p>1. Definir les classes à exporter.</p>
<pre>
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
</pre>

<p>2. Exporter les classes avec Jaxon, et définir les options adéquates.</p>
<pre>
$jaxon = Jaxon::getInstance();

$jaxonAppURI = '/jaxon/app';
$jaxonAppDir = __DIR__ . '/jaxon/app';

$this->setOption('js.app.export', true);
$this->setOption('js.app.dir', $jaxonAppDir);
$this->setOption('js.app.uri', $jaxonAppURI);
$this->setOption('js.app.minify', true); // Optionally, the file can be minified

// Register object
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
</pre>

<p>3. Appeler les classes exportées dans le code Javascript.</p>
<pre>
// Select
&lt;select onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"&gt;
&lt;/select&gt;
// Buttons
&lt;button onclick="JaxonHelloWorld.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="JaxonHelloWorld.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;
</pre>

    </div>
</div>
