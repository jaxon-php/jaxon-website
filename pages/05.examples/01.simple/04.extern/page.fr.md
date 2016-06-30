---
title: Fichier Javascript externe
menu: Fichier Javascript
template: jaxon
cache_enable: false
description: Cet exemple montre comment enregistrer le code javascript généré par la librairie dans un fichier externe.
---

<div class="row">
Par défaut, le code javascript généré par Jaxon est inséré directement dans le code HTML de la page.
Cependant, la librairie peut être configurée pour enregistrer le code généré dans un fichier, et le charger depuis le code HTML de la page.
Pour ce faire, il faut passer à la librairie un répertoire existant, et l'URI qui donne accès à ce répertoire depuis un navigateur.
</div>

<div class="row">
    <h5>Comment ça marche</h5>

<p>1. Definir la classe à exporter</p>

<pre><code class="language-php">
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
</code></pre>

<p>2. Exporter la classe avec Jaxon, et définir les options générer le code dans un fichier externe</p>

<pre><code class="language-php">
$jaxon = Jaxon::getInstance();

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
</code></pre>

<p>3. Appeler la classe exportée dans le code Javascript</p>

<pre><code class="language-php">
// Select
&lt;select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"&gt;&lt;/select&gt;
// Buttons
&lt;button onclick="JaxonHelloWorld.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="JaxonHelloWorld.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;
</code></pre>

</div>
