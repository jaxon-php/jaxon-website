---
title: Classe Hello World
menu: Classe Hello World
template: jaxon
cache_enable: false
description: Cet exemple montre l'export d'une classe avec Jaxon.
---

<div class="row">
    <div class="col-sm-12">
        <h5>Comment ça marche</h5>

<p>1. Definir les classes à exporter.</p>
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

<p>2. Exporter les classes avec Jaxon.</p>
<pre><code class="language-php">
// Register object
$jaxon = Jaxon::getInstance();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

<p>3. Appeler les classes exportées dans le code Javascript.</p>
<pre><code class="language-php">
// Select
&lt;select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"&gt;&lt;/select&gt;
// Buttons
&lt;button onclick="JaxonHelloWorld.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="JaxonHelloWorld.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;
</code></pre>

    </div>
</div>
