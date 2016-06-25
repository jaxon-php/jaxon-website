---
title: Hello World Class
menu: Hello World Class
template: jaxon
cache_enable: false
description: This example shows how to export a class with Jaxon.
---

<div class="row">
    <div class="col-sm-12">
        <h5>How it works</h5>

<p>1. Define the classes to be exported.</p>
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

<p>2. Register the classes with Jaxon.</p>
<pre><code class="language-php">
// Register object
$jaxon = Jaxon::getInstance();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

<p>3. Call the exported classes from javascript.</p>
<pre><code class="language-php">
// Select
&lt;select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"&gt;&lt;/select&gt;
// Buttons
&lt;button onclick="JaxonHelloWorld.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="JaxonHelloWorld.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;
</code></pre>

    </div>
</div>
