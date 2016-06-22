---
title: Hello World Function
menu: Hello World Function
cache_enable: false
description: This example shows how to export a function with Jaxon.
---

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">How it works</h4>
<p>1. Define the Jaxon functions</p>
<pre>
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
</pre>

<p>2. Register the Jaxon functions</p>
<pre>
$jaxon = Jaxon::getInstance();

// Register functions
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
$jaxon->register(Jaxon::USER_FUNCTION, 'setColor');

// Process the request, if any.
$jaxon->processRequest();
</pre>

<p>3. Call the Jaxon functions</p>
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
