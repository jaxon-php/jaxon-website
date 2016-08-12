---
title: Register Classes in Directories
menu: Register Directories
template: jaxon
cache_enable: false
description: This example shows how to automatically register all the classes in a set of directories.
---

When classes registered from a directory are not namespaced, they all need to have different names, even if they are in different subdirs.

#### How it works

Save classes to be registered in predefined directories, for example <code>/jaxon/class/dir/app</code> and <code>/jaxon/class/dir/ext</code>
File <code>/jaxon/class/dir/app/Test/App.php</code>
```php
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
```

File <code>/jaxon/class/dir/ext/Test/Ext.php</code>
```php
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
```

Register all the classes found in the directories
```php
$jaxon = jaxon();

// Add class dirs
$jaxon->addClassDir('/jaxon/class/dir/app');
$jaxon->addClassDir('/jaxon/class/dir/ext');

// Register objects
$jaxon->registerClasses();

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported classes from javascript
```html
// Select
<select id="colorselect1" onchange="Test.App.setColor(jaxon.$('colorselect1').value); return false;"></select>

// Buttons
<button onclick="Test.App.sayHello(0); return false;">Click Me</button>
<button onclick="Test.App.sayHello(1); return false;">CLICK ME</button>
<button onclick="Test.App.showDialog(); return false;">PgwModal Dialog</button>

// Select
<select id="colorselect2" onchange="Test.Ext.setColor(jaxon.$('colorselect2').value); return false;"></select>

// Buttons
<button onclick="Test.Ext.sayHello(0); return false;">Click Me</button>
<button onclick="Test.Ext.sayHello(1); return false;">CLICK ME</button>
<button onclick="Test.Ext.showDialog(); return false;">Bootstrap Dialog</button>
```
