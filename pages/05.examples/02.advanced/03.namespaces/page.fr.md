---
title: Exporter des classes dans des répertoires avec namespaces
menu: Exporter des namespaces
template: jaxon
cache_enable: false
description: Cet exemple montre comment exporter automatiquement toutes les classes présentes dans un ensemble de répertoires avec des namespaces.
---

<div class="row">
Le nom des classes javascript générées est préfixé avec le namespace, et des classes PHP dans des sous-répertoires différents peuvent avoir le même nom.
</div>

<div class="row">
    <h5>Comment ça marche</h5>

<p>1. Placer les classes à exporter dans des répertoires associés à des namespaces, par exemple <code>/jaxon/class/dir/app</code> et <code>/jaxon/class/dir/ext</code></p>

<p>Fichier <code>/jaxon/class/dir/app/Test/App.php</code></p>
<pre><code class="language-php">
namespace App\Test;

use Jaxon\Response\Response;

class Test
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
        $xResponse = new Response();
        $xResponse->assign('div1', 'innerHTML', $text);
        $xResponse->toastr->success("div1 text is now $text");
        return $xResponse;
    }

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div1', 'style.color', $sColor);
        $xResponse->toastr->success("div1 color is now $sColor");
        return $xResponse;
    }

    public function showDialog()
    {
        $xResponse = new Response();
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        $xResponse->pgw->modal("Modal Dialog", "This modal dialog is powered by PgwModal!!", $buttons, $options);
        return $xResponse;
    }
}
</code></pre>

<p>Fichier <code>/jaxon/class/dir/ext/Test/Ext.php</code></p>
<pre><code class="language-php">
namespace Ext\Test;

use Jaxon\Response\Response;

class Test
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
        $xResponse = new Response();
        $xResponse->assign('div2', 'innerHTML', $text);
        $xResponse->toastr->success("div2 text is now $text");
        return $xResponse;
    }

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);
        $xResponse->toastr->success("div2 color is now $sColor");
        return $xResponse;
    }

    public function showDialog()
    {
        $xResponse = new Response();
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $width = 300;
        $xResponse->bootstrap->modal("Modal Dialog", "This modal dialog is powered by Twitter Bootstrap!!", $buttons, $width);
        return $xResponse;
    }
}
</code></pre>

<p>2. Exporter toutes les classes présentes dans les répertoires avec leur namespace</p>
<pre><code class="language-php">
$jaxon = Jaxon::getInstance();

// Add class dirs with namespaces
$jaxon->addClassDir('/jaxon/class/dir/app', 'App');
$jaxon->addClassDir('/jaxon/class/dir/ext', 'Ext');

// Register objects
$jaxon->registerClasses();

// Process the request, if any.
$jaxon->processRequest();
</code></pre>

<p>3. Appeler les classes exportées dans le code Javascript</p>
<pre><code class="language-html">
// Select
&lt;select id="colorselect1" onchange="App.Test.Test.setColor(jaxon.$('colorselect1').value); return false;"&gt;&lt;/select&gt;

// Buttons
&lt;button onclick="App.Test.Test.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="App.Test.Test.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;
&lt;button onclick="App.Test.Test.showDialog(); return false;"&gt;Show PgwModal Dialog&lt;/button&gt;

// Select
&lt;select id="colorselect2" onchange="Ext.Test.Test.setColor(jaxon.$('colorselect2').value); return false;"&gt;&lt;/select&gt;

// Buttons
&lt;button onclick="Ext.Test.Test.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="Ext.Test.Test.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;
&lt;button onclick="Ext.Test.Test.showDialog(); return false;"&gt;Show Twitter Bootstrap Dialog&lt;/button&gt;
</code></pre>

</div>
