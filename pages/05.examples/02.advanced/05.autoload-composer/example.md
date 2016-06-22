---
title: Autoload with Composer
menu: Autoload with Composer
cache_enable: false
description: This example illustrates the use of the Composer autoloader.
---

By default, the Jaxon library implements a simple autoloading mechanism by require_once'ing the corresponding PHP file for each missing class. When provided with the Composer autoloader, the Jaxon library registers all directories with a namespace into the PSR-4 autoloader, and it registers all the classes in directories with no namespace into the classmap autoloader.

<div class="row">
    <div class="col-sm-12">
        <h4 class="page-header">How it works</h4>
<p>The Jaxon class in the file ./classes/namespace/app/Test/Test.php</p>
<pre>
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
</pre>

<p>The Jaxon class in the file ./classes/namespace/ext/Test/Test.php</p>
<pre>
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
</pre>

<p>The javascript event bindings</p>
<pre>
// Select
&lt;select onchange="App.Test.Test.setColor(jaxon.$('colorselect').value); return false;"&gt;
&lt;/select&gt;

// Buttons
&lt;button onclick="App.Test.Test.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="App.Test.Test.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;

// Select
&lt;select onchange="Ext.Test.Test.setColor(jaxon.$('colorselect').value); return false;"&gt;
&lt;/select&gt;

// Buttons
&lt;button onclick="Ext.Test.Test.sayHello(0); return false;"&gt;Click Me&lt;/button&gt;
&lt;button onclick="Ext.Test.Test.sayHello(1); return false;"&gt;CLICK ME&lt;/button&gt;

&lt;button onclick="App.Test.Test.showDialog(); return false;"&gt;Show PgwModal Dialog&lt;/button&gt;
&lt;button onclick="Ext.Test.Test.showDialog(); return false;"&gt;Show Twitter Bootstrap Dialog&lt;/button&gt;
</pre>

<p>The PHP object registrations</p>
<pre>
require(__DIR__ . '/vendor/autoload.php');

$jaxon = Jaxon::getInstance();

$jaxon->setOption('core.debug.on', false);
$jaxon->setOption('core.prefix.class', '');

// Use the Composer autoloader
$jaxon->useComposerAutoloader();

// Add class dirs with namespaces
$jaxon->addClassDir(__DIR__ . '/classes/namespace/app', 'App');
$jaxon->addClassDir(__DIR__ . '/classes/namespace/ext', 'Ext');

// Check if there is a request.
if($jaxon->canProcessRequest())
{
    // When processing a request, the required class will be autoloaded
    $jaxon->processRequest();
}
else
{
    // The Jaxon objects are registered only when the page is loaded
    $jaxon->registerClasses();
}
</pre>
    </div>
</div>
