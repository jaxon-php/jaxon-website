---
title: Register Classes in Namespaces
menu: Register Namespaces
template: jaxon
cache_enable: false
description: This example shows how to automatically register all the classes in a set of directories with namespaces.
---

The namespace name is prepended to the generated javascript class names, and PHP classes in different subdirs can have the same name.

#### How it works

Save classes to be registered in directories associated with namespaces, for example <code>/jaxon/class/dir/app</code> and <code>/jaxon/class/dir/ext</code>
File <code>/jaxon/class/dir/app/Test/App.php</code>

```php
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
```

The Jaxon class in the file ./classes/namespace/ext/Test/Test.php
```php
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
```

Register all the classes found in the directories with their respective namespaces
```php
$jaxon = jaxon();

// Add class dirs with namespaces
$jaxon->addClassDir('/jaxon/class/dir/app', 'App');
$jaxon->addClassDir('/jaxon/class/dir/ext', 'Ext');

// Register objects
$jaxon->registerClasses();

// Process the request, if any.
$jaxon->processRequest();
```

Call the exported classes from javascript
```html
// Select
<select id="colorselect" onchange="App.Test.Test.setColor(jaxon.$('colorselect').value); return false;"></select>

// Buttons
<button onclick="App.Test.Test.sayHello(0); return false;">Click Me</button>
<button onclick="App.Test.Test.sayHello(1); return false;">CLICK ME</button>

// Select
<select id="colorselect" onchange="Ext.Test.Test.setColor(jaxon.$('colorselect').value); return false;"></select>

// Buttons
<button onclick="Ext.Test.Test.sayHello(0); return false;">Click Me</button>
<button onclick="Ext.Test.Test.sayHello(1); return false;">CLICK ME</button>

<button onclick="App.Test.Test.showDialog(); return false;">PgwModal Dialog</button>
<button onclick="Ext.Test.Test.showDialog(); return false;">Bootstrap Dialog</button>
```
