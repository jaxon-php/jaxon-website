---
title: Hello World Function
menu: Hello World Function
template: jaxon
cache_enable: false
description: This example shows how to export a function with Jaxon.
---

<div class="row">
    <div class="col-sm-12">
        <h5>How it works</h5>

<p>1. Define the functions to be exported.</p>
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

<p>2. Register the functions with Jaxon.</p>
<pre><code class="language-php">
$jaxon = Jaxon::getInstance();

// Register functions
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
$jaxon->register(Jaxon::USER_FUNCTION, 'setColor');

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

<p>3. Call the exported functions from javascript.</p>
<pre><code class="language-php">
// Select
&lt;select id="colorselect" onchange="jaxon_setColor(jaxon.$('colorselect').value); return false;"&gt;&lt;/select&gt;
// Buttons
&lt;button onclick="jaxon_helloWorld(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="jaxon_helloWorld(1); return false;"&gt;CLICK ME&lt;/button&gt;
</code></pre>

    </div>
</div>
