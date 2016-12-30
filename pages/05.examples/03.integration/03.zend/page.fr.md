---
title: Le plugin Zend
menu: Le plugin Zend
template: jaxon
cache_enable: false
description: Cet exemple montre l'utilisation du [plugin Jaxon pour le Zend Framework](https://github.com/jaxon-php/jaxon-zend?target=_blank).
---

Ce plugin initialise et configure la librairie Jaxon, et laisse au développeur le soin d'écrire les classes Jaxon pour son application.

La configuration de la librairie Jaxon se fait dans le fichier `config/jaxon.config.php` à la racine de l'application.

Par défaut, le plugin Jaxon enregistre les classes dans le répertoire `jaxon` à la racine de l'application, avec le namespace `\Jaxon\App`.

#### Comment ça marche

Installer et configurer le plugin jaxon pour Zend, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-zend?target=_blank).

Dans le contrôleur de l'application, insérer le code généré par la librairie Jaxon dans la page.

```php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DemoController extends AbstractActionController
{
    public function indexAction()
    {
        // Call the Jaxon module
        $jaxon = $this->getServiceLocator()->get('JaxonPlugin');
        $jaxon->register();

        $view = new ViewModel(array(
            'JaxonCss' => $jaxon->css(),
            'JaxonJs' => $jaxon->js(),
            'JaxonScript' => $jaxon->script(),
        ));
        $view->setTemplate('demo/index');
        return $view;
    }
}
```

Placer les fichiers Jaxon de l'application dans le répertoire `jaxon` à la racine de l'application.

Dans cet exemple il y a deux fichiers `Bts.php` and `Pgw.php` dans le répertoire `jaxon/Test`.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Zend\Controller
{
    public function sayHello($isCaps)
    {
        $html = $this->view->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div2', 'innerHTML', $html);

        $message = $this->view->render('test/message', [
            'element' => 'div2',
            'attr' => 'text',
            'value' => $html,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function setColor($sColor)
    {
        $this->response->assign('div2', 'style.color', $sColor);

        $message = $this->view->render('test/message', [
            'element' => 'div2',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $width = 300;
        $html = $this->view->render('test/credit', ['library' => 'Twitter Bootstrap']);
        $this->response->bootstrap->modal("Modal Dialog", $html, $buttons, $width);
    
        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\Zend\Controller
{
    public function sayHello($isCaps)
    {
        $html = $this->view->render('test/hello', ['isCaps' => $isCaps]);
        $this->response->assign('div1', 'innerHTML', $html);

        $message = $this->view->render('test/message', [
            'element' => 'div1',
            'attr' => 'text',
            'value' => $html,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function setColor($sColor)
    {
        $this->response->assign('div1', 'style.color', $sColor);
        $message = $this->view->render('test/message', [
            'element' => 'div1',
            'attr' => 'color',
            'value' => $sColor,
        ]);
        $this->response->toastr->success($message);
    
        return $this->response;
    }
    
    public function showDialog()
    {
        $buttons = array(array('title' => 'Close', 'class' => 'btn', 'click' => 'close'));
        $options = array('maxWidth' => 400);
        $html = $this->view->render('test/credit', ['library' => 'PgwModal']);
        $this->response->pgw->modal("Modal Dialog", $html, $buttons, $options);
    
        return $this->response;
    }
}
```
