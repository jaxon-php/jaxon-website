---
title: Calling a plugin
menu: Calling a plugin
template: jaxon
---

In the exported classes, get access to the plugin using the `Response` object.

```php
class HelloWorld
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function sayHello($isCaps)
    {
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $this->response->assign('div2', 'innerHTML', $text);

        // Call the Dialog plugin
        $this->response->dialog->success("div2 text is now $text");

        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div2', 'style.color', $sColor);

        // Call the Dialog plugin
        $this->response->dialog->success("div2 color is now $sColor");

        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('width' => 500);

        // Call the Dialog plugin
        $this->response->dialog->modal("Modal Dialog", "This modal dialog is powered by PgwJs!!", $buttons, $options);

        return $this->response;
    }
}
```

The configuration options in Yaml format.

```yaml
jaxon:
  core:
    debug:
      on:                          true
    prefix:
      class:                       "Jaxon"
    request:
      csrf_meta:                   "csrf-token"
  
  dialogs:
    default:
      modal:                       pgwjs
      alert:                       toastr
    pgwjs:
      assets:
        include:                   true
      modal:
        options:
          closeOnEscape:           true
          closeOnBackgroundClick:  true
          maxWidth:                600
    toastr:
      options:
        closeButton:               true
        closeMethod:               "fadeOut"
        closeDuration:             300
        closeEasing:               "swing"
        positionClass:             "toast-top-center"
```
