---
title: Plugin de réponse
menu: Plugin de réponse
template: jaxon
cache_enable: false
description: Cet exemple montre l'utilisation des plugins de réponse de Jaxon, en ajoutant des notifications et des fenêtres modales à l'exemple Classe Hello World avec les plugins jaxon-toastr, jaxon-pgwjs and jaxon-bootstrap.
---

L'utilisation d'un plugin de réponse est très simple. Après son installation, le plugin s'enregistre automatiquement dans la librairie Jaxon. Il devient alors accessible depuis la classe Response de Jaxon, pour fournir ses fonctions à l'application.

#### Comment ça marche

Installer les plugins
```json
"require": {
    "jaxon-php/jaxon-toastr": "dev-master",
    "jaxon-php/jaxon-pgwjs": "dev-master",
    "jaxon-php/jaxon-bootstrap": "dev-master"
}
```

Dans les classes exportées, accéder aux plugins via l'objet Response

```php
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

    public function showDialog()
    {
        $xResponse = new Response();
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        // Call the PgwModal plugin
        $xResponse->pgw->modal("Modal Dialog", "This modal dialog is powered by PgwModal!!", $buttons, $options);
        return $xResponse;
    }
}
```

Pendant l'export des classes, définir les paramètres des plugins

```php
$jaxon = jaxon();

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
```

Appeler la classe exportée dans le code Javascript

```php
// Select
<select id="colorselect" onchange="JaxonHelloWorld.setColor(jaxon.$('colorselect').value); return false;"></select>
// Buttons
<button onclick="JaxonHelloWorld.sayHello(0); return false;">Click Me</button>
<button onclick="JaxonHelloWorld.sayHello(1); return false;">CLICK ME</button>

<button onclick="JaxonHelloWorld.showDialog(); return false;">PgwModal Dialog</button>
```
