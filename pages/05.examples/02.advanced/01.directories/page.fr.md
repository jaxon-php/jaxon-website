---
title: Exporter des classes dans des répertoires
menu: Exporter des répertoires
template: jaxon
cache_enable: false
description: Cet exemple montre comment exporter automatiquement toutes les classes présentes dans un ensemble de répertoires.
---

Lorsque les classes exportées d'un répertoire n'ont pas de namespace, elles doivent avoir des noms différents, même si elles ne sont pas dans le même sous-répertoire.

#### Comment ça marche

Placer les classes à exporter dans des répertoires définis, par exemple <code>/jaxon/class/dir/app</code> et <code>/jaxon/class/dir/ext</code>

Fichier <code>/jaxon/class/dir/app/Test/App.php</code>
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

Fichier <code>/jaxon/class/dir/ext/Test/Ext.php</code>
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

Exporter toutes les classes présentes dans les répertoires
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

Appeler les classes exportées dans le code Javascript
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
