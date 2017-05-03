---
title: Jaxon Armada
menu: Armada
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation de [Jaxon Armada](/docs/armada/operation).

#### Comment ça marche

Une application Jaxon Armada démarre à partir d'un fichier de configuration, [comme celui-ci](https://github.com/jaxon-php/jaxon-examples/tree/master/armada/config).

```php
$armada = jaxon()->armada();
$armada->config('/path/to/config.php');
$armada->register();
```

Les classes de l'application sont chargées à partir des répertoires indiqués dans la configuration.
Dans cet exemple il y a deux fichiers `Bts.php` and `Pgw.php` dans le répertoire `Test`.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Sentry\Classes\Base
{
    public function sayHello($isCaps, $bNotify = true)
    {
        $html = $this->view()->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div2', 'innerHTML', $html);
        if(($bNotify))
        {
            // Show a success notification.
            $message = $this->view()->render('test/message', [
                'element' => 'div2',
                'attr' => 'text',
                'value' => $html,
            ]);
            $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));
        }

        return $this->response;
    }

    public function setColor($sColor, $bNotify = true)
    {
        $this->response->assign('div2', 'style.color', $sColor);
        $this->response->dialog->hide();
        if(($bNotify))
        {
            // Show a success notification.
            $message = $this->view()->render('test/message', [
                'element' => 'div2',
                'attr' => 'color',
                'value' => $sColor,
            ]);
            $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));
        }

        return $this->response;
    }

    public function showDialog()
    {
        $buttons = array(
            array(
                'title' => 'Close',
                'class' => 'btn',
                'click' => 'close'
            )
        );
        $width = 300;
        $html = $this->view()->render('test/credit', ['library' => 'Twitter Bootstrap']);
        $this->response->dialog->show("Modal Dialog", $html, $buttons, compact('width'));

        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\Sentry\Classes\Base
{
    public function sayHello($isCaps, $bNotify = true)
    {
        $html = $this->view()->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div1', 'innerHTML', $html);
        if(($bNotify))
        {
            // Show a success notification.
            $message = $this->view()->render('test/message', [
                'element' => 'div1',
                'attr' => 'text',
                'value' => $html,
            ]);
            $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));
        }

        return $this->response;
    }

    public function setColor($sColor, $bNotify = true)
    {
        $this->response->assign('div1', 'style.color', $sColor);
        if(($bNotify))
        {
            // Show a success notification.
            $message = $this->view()->render('test/message', [
                'element' => 'div1',
                'attr' => 'color',
                'value' => $sColor,
            ]);
            $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));
        }

        return $this->response;
    }

    public function showDialog()
    {
        $this->response->dialog->setModalLibrary('pgwjs');

        $buttons = array(
            array(
                'title' => 'Close',
                'class' => 'btn',
                'click' => 'close'
            )
        );
        $options = array('maxWidth' => 400);
        $html = $this->view()->render('test/credit', ['library' => 'PgwModal']);
        $this->response->dialog->show("Modal Dialog", $html, $buttons, $options);

        return $this->response;
    }
}
```
