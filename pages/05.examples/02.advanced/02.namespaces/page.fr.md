---
title: Exporter des classes dans des namespaces
menu: Exporter des namespaces
template: jaxon
cache_enable: false
---

Cet exemple montre comment exporter automatiquement toutes les classes présentes dans un ensemble de répertoires avec des namespaces.

Le nom des classes javascript générées est préfixé avec le namespace, et des classes PHP dans des sous-répertoires différents peuvent avoir le même nom.

#### Comment ça marche

Placer les classes à exporter dans des répertoires associés à des namespaces, par exemple <code>/jaxon/class/dir/app</code> et <code>/jaxon/class/dir/ext</code>

Fichier <code>/jaxon/class/dir/app/Test/App.php</code>
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

Fichier <code>/jaxon/class/dir/ext/Test/Ext.php</code>
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

Exporter toutes les classes présentes dans les répertoires avec leur namespace
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

Appeler les classes exportées dans le code Javascript
```html
// Select
<select id="colorselect1" onchange="App.Test.Test.setColor(jaxon.$('colorselect1').value); return false;"></select>

// Buttons
<button onclick="App.Test.Test.sayHello(0); return false;">Click Me</button>
<button onclick="App.Test.Test.sayHello(1); return false;">CLICK ME</button>
<button onclick="App.Test.Test.showDialog(); return false;">PgwModal Dialog</button>

// Select
<select id="colorselect2" onchange="Ext.Test.Test.setColor(jaxon.$('colorselect2').value); return false;"></select>

// Buttons
<button onclick="Ext.Test.Test.sayHello(0); return false;">Click Me</button>
<button onclick="Ext.Test.Test.sayHello(1); return false;">CLICK ME</button>
<button onclick="Ext.Test.Test.showDialog(); return false;">Bootstrap Dialog</button>
```
