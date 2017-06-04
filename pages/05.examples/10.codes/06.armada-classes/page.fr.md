---
title: Les classes Armada
menu: Les classes Armada
template: jaxon
---

Dans cet exemple il y a deux fichiers `Bts.php` and `Pgw.php` dans le sous-répertoire `Test`, et le namespace `Jaxon\App\Test`.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Sentry\Classes\Armada
{
    public function sayHello($isCaps)
    {
        $html = $this->view()->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div2', 'innerHTML', $html);

        // Show a success notification.
        $message = $this->view()->render('test/message', [
            'element' => 'div2',
            'attr' => 'text',
            'value' => $html,
        ]);
        $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));

        return $this->response;
    }

    public function setColor($sColor, $bNotify = true)
    {
        $this->response->assign('div2', 'style.color', $sColor);
        $this->response->dialog->hide();

        // Show a success notification.
        $message = $this->view()->render('test/message', [
            'element' => 'div2',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));

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
        $options = array('width' => 500);
        $html = $this->view()->render('test/credit', ['library' => 'Twitter Bootstrap']);
        $this->response->dialog->show("Modal Dialog", $html, $buttons, $options);

        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\Sentry\Classes\Armada
{
    public function sayHello($isCaps, $bNotify = true)
    {
        $html = $this->view()->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div1', 'innerHTML', $html);

        // Show a success notification.
        $message = $this->view()->render('test/message', [
            'element' => 'div1',
            'attr' => 'text',
            'value' => $html,
        ]);
        $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));

        return $this->response;
    }

    public function setColor($sColor, $bNotify = true)
    {
        $this->response->assign('div1', 'style.color', $sColor);

        // Show a success notification.
        $message = $this->view()->render('test/message', [
            'element' => 'div1',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->dialog->success($message, $this->session()->get('DialogTitle', 'No title'));

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
