---
title: Hello World Alias
menu: Hello World Alias
cache_enable: false
description: This example shows how to export the methods of a class as functions with Jaxon, using aliases.
---

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">How it works</h4>
<p>The Jaxon class</p>
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

<p>The PHP object registrations</p>
<pre>
$jaxon = Jaxon::getInstance();

// Register class methods as Jaxon functions
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, array('helloWorld', $hello, 'sayHello'));
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, 'setColor'));

// Process the request, if any.
$jaxon->processRequest();
</pre>

<p>The javascript event bindings</p>
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
