---
title: Plugin Usage
menu: Plugin Usage
template: jaxon
cache_enable: false
description: Cet exemple montre l'utilisation des plugins de réponse de Jaxon, en ajoutant des notifications et des fenêtres modales à l'exemple Classe Hello World avec les plugins jaxon-toastr, jaxon-pgwjs and jaxon-bootstrap.
---

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">&nbsp;</h4>
L'utilisation d'un plugin de réponse est très simple. Après son installation, le plugin s'enregistre automatiquement dans la librairie Jaxon. Il devient alors accessible depuis la classe Response de Jaxon, pour fournir ses fonctions à l'application.
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <h5>Comment ça marche</h5>

<p>1. Installer les plugins</p>
<pre><code class="language-php">
</code></pre>

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

<p>The PHP object registrations</p>
<pre><code class="language-php">
$jaxon = Jaxon::getInstance();

$jaxon->setOption('core.debug.on', false);
$jaxon->setOption('core.prefix.class', 'Jaxon');

$jaxon->setOptions(array(
    'toastr.options.closeButton' => true,
    'toastr.options.closeMethod' => 'fadeOut',
    'toastr.options.closeDuration' => 300,
    'toastr.options.closeEasing' => 'swing',
    'toastr.options.positionClass' => 'toast-bottom-left',
));

$jaxon->setOptions(array(
    'pgw.modal.options.closeOnEscape' => true,
    'pgw.modal.options.closeOnBackgroundClick' => true,
    'pgw.modal.options.maxWidth' => 600,
));

// Register object
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());

// Process the request, if any.
$jaxon->processRequest();
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

    </div>
</div>
