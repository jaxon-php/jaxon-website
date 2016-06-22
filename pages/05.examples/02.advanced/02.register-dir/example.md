---
title: Register Directories
menu: Register Directories
cache_enable: false
description: This example shows how to automatically register all the PHP classes in a set of directories.
---

The classes in this example are not namespaced, thus they all need to have different names, even if they are in different subdirs.

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">How it works</h4>
<p>The Jaxon class in the file ./classes/simple/app/Test/App.php</p>
<pre>
use Jaxon\Response\Response;

class App
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
</pre>

<p>The Jaxon class in the file ./classes/simple/ext/Test/Ext.php</p>
<pre>
use Jaxon\Response\Response;

class Ext
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
</pre>

<p>The javascript event bindings</p>
<pre>
// Select
&lt;select onchange="Test.App.setColor(jaxon.$('colorselect').value); return false;"&gt;
&lt;/select&gt;

// Buttons
&lt;button onclick="Test.App.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="Test.App.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;

// Select
&lt;select onchange="Test.Ext.setColor(jaxon.$('colorselect').value); return false;"&gt;
&lt;/select&gt;

// Buttons
&lt;button onclick="Test.Ext.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="Test.Ext.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;

&lt;button onclick="Test.App.showDialog(); return false;"&gt;Show PgwModal Dialog&lt;/button&gt;
&lt;button onclick="Test.Ext.showDialog(); return false;"&gt;Show Twitter Bootstrap Dialog&lt;/button&gt;
</pre>

<p>The PHP object registrations</p>
<pre>
$jaxon = Jaxon::getInstance();

$jaxon->setOption('core.debug.on', false);
$jaxon->setOption('core.prefix.class', '');

// Add class dirs
$jaxon->addClassDir(__DIR__ . '/classes/simple/app');
$jaxon->addClassDir(__DIR__ . '/classes/simple/ext');

// Register objects
$jaxon->registerClasses();

// Process the request, if any.
$jaxon->processRequest();
</pre>
    </div>
</div>
