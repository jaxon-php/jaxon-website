---
title: Yii Module
menu: Yii Module
template: jaxon
cache_enable: false
description: This example shows the usage of the Jaxon plugin for the Yii framework.
---

The module implements all the setup of the Jaxon library, and let the user focus on writing Jaxon classes for his application.

The behaviour of the Jaxon library can be customized from a Yii-specific config file.

By default, the Jaxon plugin for Yii registers all classes in the jaxon/ dir, with namespace \Jaxon\App.

<div class="row">
    <div class="col-sm-12">
        <h5>How it works</h5>
<p>In this example we have two files Bts.php and Pgw.php in the jaxon/Test/ directory</p>
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

<h5><b>Installation</b></h5>
<p>
See https://github.com/jaxon-php/jaxon-yii for how to install the Jaxon module fot Yii.
</p>

<h5><b>The Jaxon controller</b></h5>
<p>
This is the Jaxon demo controller.
</p>
<pre><code class="language-php">
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

class DemoController extends Controller
{
    protected $jaxon = null;

    public function actionIndex()
    {
        $this->jaxon = Yii::$app->getModule('jaxon');
        // Set the layout
        $this->layout = 'demo';
        // Call the Jaxon module
        $this->jaxon->register();

        return $this->render('index', array(
            'JaxonCss' => $this->jaxon->css(),
            'JaxonJs' => $this->jaxon->js(),
            'JaxonScript' => $this->jaxon->script(),
        ));
    }

    public function actionProcess()
    {
        $this->jaxon = Yii::$app->getModule('jaxon');
        // Process Jaxon request
        if($this->jaxon->canProcessRequest())
        {
            $this->jaxon->processRequest();
        }
    }
}
</code></pre>

<h5><b>Configuration</b></h5>
<p>The config file is located at <em>config/jaxon.php</em></p>
<p>
The config options are separated into two entries. The <em>lib</em> entry provides the options for
the Jaxon library, while the <em>app</em> entry provides the options for the Yii application.
</p>
<pre><code class="language-php">
return array(
    'app' => array(
        // 'dir' => '',
        // 'namespace' => '',
        // 'excluded' => array(),
    ),
    'lib' => array(
        'core' => array(
            'language' => 'en',
            'encoding' => 'UTF-8',
            'request' => array(
'uri' => 'jaxon',
            ),
            'prefix' => array(
'class' => '',
            ),
            'debug' => array(
'on' => false,
'verbose' => false,
            ),
            'error' => array(
'handle' => false,
            ),
        ),
        'js' => array(
            'lib' => array(
// 'uri' => '',
            ),
            'app' => array(
// 'uri' => '',
// 'dir' => '',
// 'export' => true,
// 'minify' => true,
'options' => '',
            ),
        ),
    ),
);
</code></pre>
    </div>
</div>
