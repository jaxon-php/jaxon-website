---
title: Config File
menu: Config File
template: jaxon
cache_enable: false
description: This example features the same code as the Plugins Usage example, excepted that the config is loaded from a config file in Yaml format.
---

When loading settings from a file, a second parameter can be added to make the library load the options from a particular section of the file.
In this example, the config options are under the "jaxon" section of the file.

<div class="row">
    <div class="col-sm-12">
        <h5>How it works</h5>
<p>The Jaxon class</p>
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
        // Call the Toastr plugin
        $xResponse->toastr->success("div2 text is now $text");
        return $xResponse;
    }

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);
        // Call the Toastr plugin
        $xResponse->toastr->success("div2 color is now $sColor");
        return $xResponse;
    }

    public function showPgwDialog()
    {
        $xResponse = new Response();
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        // Call the PgwModal plugin
        $xResponse->pgw->modal("Modal Dialog", "This modal dialog is powered by PgwModal!!", $buttons, $options);
        return $xResponse;
    }

    public function showTbDialog()
    {
        $xResponse = new Response();
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $width = 300;
        // Call the Twitter Bootstrap plugin
        $xResponse->bootstrap->modal("Modal Dialog", "This modal dialog is powered by Twitter Bootstrap!!", $buttons, $width);
        return $xResponse;
    }
}
</code></pre>

<p>The javascript event bindings</p>
<pre><code class="language-php">
// Select
&lt;select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"&gt;&lt;/select&gt;
// Buttons
&lt;button onclick="JaxonHelloWorld.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="JaxonHelloWorld.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;

&lt;button onclick="JaxonHelloWorld.showPgwDialog(); return false;"&gt;Show PgwModal Dialog&lt;/button&gt;
&lt;button onclick="JaxonHelloWorld.showTbDialog(); return false;"&gt;Show Twitter Bootstrap Dialog&lt;/button&gt;
</code></pre>

<p>The PHP object registrations</p>
<pre><code class="language-php">
\Jaxon\Config\Yaml::read(__DIR__ . '/config/config.yaml', 'jaxon');

// Register object
$jaxon = Jaxon::getInstance();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

<p>The Yaml config file</p>
<pre><code class="language-php">
jaxon:
  core:
    debug:
      on:          true
    prefix:
      class:       "Jaxon"
  
  toastr:
    options:
      closeButton: true
      closeMethod: "fadeOut"
      closeDuration:               300
      closeEasing: "swing"
      positionClass:               "toast-bottom-left"
  
  pgw:
    assets:
      include:     true
    modal:
      options:
        closeOnEscape:             true,
        closeOnBackgroundClick:    true,
        maxWidth:  600
</code></pre>
    </div>
</div>
