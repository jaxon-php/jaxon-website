---
title: Laravel Plugin
menu: Laravel Plugin
template: jaxon
cache_enable: false
description: This example shows the usage of the Jaxon plugin for the Laravel framework.
---

The plugin implements all the setup of the Jaxon library, and let the user focus on writing Jaxon classes for his application.

The behaviour of the Jaxon library can be customized from a Laravel-specific config file.

By default, the Jaxon plugin for Laravel registers all classes in the app/Jaxon/Controllers/ dir, with namespace \Jaxon\App.

<div class="row">
    <h5>Comment ça marche</h5>

<p>1. Install and configure the Jaxon plugin for Laravel, as described in the [plugin documentation](https://github.com/jaxon-php/jaxon-laravel)</p>

<p>In this example we have two files Bts.php and Pgw.php in the app/Jaxon/Controllers/Test/ directory</p>

<pre><code class="language-php">
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Framework\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div2', 'innerHTML', $text);
        $this->response->toastr->success("div2 text is now $text, after calling " . $this->call('sayHello', $isCaps));
    
        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div2', 'style.color', $sColor);
        $this->response->toastr->success("div2 color is now $sColor");
    
        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $width = 300;
        $this->response->bootstrap->modal("Modal Dialog", "This modal dialog is powered by Twitter Bootstrap!!", $buttons, $width);
    
        return $this->response;
    }
}
</code></pre>

<pre><code class="language-php">
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\Framework\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div1', 'innerHTML', $text);
        $this->response->toastr->success("div1 text is now $text, after calling " . $this->call('sayHello', $isCaps));
    
        return $this->response;
    }

    public function setColor($sColor)
    {
        $this->response->assign('div1', 'style.color', $sColor);
        $this->response->toastr->success("div1 color is now $sColor");
    
        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        $this->response->pgw->modal("Modal Dialog", "This modal dialog is powered by PgwModal!!", $buttons, $options);
    
        return $this->response;
    }
}
</code></pre>

</div>
