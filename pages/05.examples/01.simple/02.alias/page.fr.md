---
title: Alias Hello World
menu: Alias Hello World
template: examples
cache_enable: false
description: Cet exemple montre l'export des méthodes d'une classe comme des fonction, à l'aide d'alias.
---

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">Comment ça marche</h4>

<p>1. Définir les classes dont les méthodes doivent être exportées.</p>
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

<p>2. Exported les méthodes vers des fonctions javascript.</p>
<pre>
$jaxon = Jaxon::getInstance();

// Register class methods as Jaxon functions
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, array('helloWorld', $hello, 'sayHello'));
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, 'setColor'));

// Process the request, if any.
$jaxon->processRequest();
</pre>

<p>3. Appeler les fonctions exportées dans le code Javascript.</p>
<pre>
// Select
&lt;select onchange="jaxon_setColor(jaxon.$('colorselect').value); return false;"&gt;
&lt;/select&gt;
// Buttons
&lt;button onclick="jaxon_helloWorld(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="jaxon_helloWorld(1); return false;"&gt;CLICK ME&lt;/button&gt;
</pre>

    </div>
</div>
