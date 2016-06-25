---
title: Fonction Hello World
menu: Fonction Hello World
template: jaxon
cache_enable: false
description: Cet exemple montre l'export d'une fonction avec Jaxon.
---

<div class="row">
    <div class="col-sm-12">
        <h5>Comment ça marche</h5>

<p>1. Definir les fonctions à exporter.</p>
<pre><code class="language-php">
function helloWorld($isCaps)
{
    if ($isCaps)
        $text = 'HELLO WORLD!';
    else
        $text = 'Hello World!';

    $xResponse = new Response();
    $xResponse->assign('div1', 'innerHTML', $text);

    return $xResponse;
}

function setColor($sColor)
{
    $xResponse = new Response();
    $xResponse->assign('div1', 'style.color', $sColor);

    return $xResponse;
}
</code></pre>

<p>2. Exporter les fonctions avec Jaxon.</p>
<pre><code class="language-php">
$jaxon = Jaxon::getInstance();

// Register functions
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
$jaxon->register(Jaxon::USER_FUNCTION, 'setColor');

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

<p>3. Appeler les fonctions exportées dans le code Javascript.</p>
<pre><code class="language-php">
// Select
&lt;select id="colorselect" onchange="jaxon_setColor(jaxon.$('colorselect').value); return false;"&gt;&lt;/select&gt;
// Buttons
&lt;button onclick="jaxon_helloWorld(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="jaxon_helloWorld(1); return false;"&gt;CLICK ME&lt;/button&gt;
</code></pre>

    </div>
</div>
