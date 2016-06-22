---
title: Hello World Class
menu: Hello World Class
cache_enable: false
description: This example shows how to export a class with Jaxon.
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
\Jaxon\Config\Php::read(__DIR__ . '/config/class.php', 'lib');

// Register object
$jaxon = Jaxon::getInstance();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
</pre>

<p>The PHP config file</p>
<pre>
return array(
    'lib' => array(
        'core' => array(
            'debug' => array(
                'on' => false,
            ),
            'prefix' => array(
                'class' => 'Xjx',
            ),
        ),
    ),
);
</pre>

<p>The javascript event bindings</p>
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
