---
title: Le plugin CakePHP
menu: Le plugin CakePHP
template: jaxon
cache_enable: false
description: Cet exemple montre l'utilisation du [plugin Jaxon pour le framework CakePHP](https://github.com/jaxon-php/jaxon-cake?target=_blank).
---

Ce plugin initialise et configure la librairie Jaxon, et laisse au développeur le soin d'écrire les classes Jaxon pour son application.

La configuration de la librairie Jaxon se fait dans un fichier au format CakePHP, nommé `config/jaxon.php`.

Par défaut, le plugin Jaxon enregistre les classes dans le répertoire `ROOT/jaxon/Controller/` de l'application CakePHP, avec le namespace `\Jaxon\App`.

#### Comment ça marche

Installer et configurer le plugin jaxon pour CakePHP, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-cake?target=_blank)

Dans le contrôleur du framework, insérer le code généré par la librairie dans la page en utilisant ses fonctions de gestion des vues

```php
namespace App\Controller;

class DemoController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        // Load the Jaxon component
        $this->loadComponent('Jaxon/Cake.Jaxon');
    }

    public function index()
    {
        // Call the Jaxon module
        $this->Jaxon->register();

        $this->set('jaxonCss', $this->Jaxon->css());
        $this->set('jaxonJs', $this->Jaxon->js());
        $this->set('jaxonScript', $this->Jaxon->script());
        $this->render('demo');
    }
}
```

Placer les fichiers Jaxon de l'application dans le répertoire `ROOT/jaxon/Controller`

Dans cet exemple il y a deux fichiers `Bts.php` and `Pgw.php` dans le répertoire `ROOT/jaxon/Controller/Test`.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Cake\Controller
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
        $options = array('width' => 300);
        $html = $this->view->render('test/credit', ['library' => 'Twitter Bootstrap']);
        $this->response->bootstrap->modal("Modal Dialog", $html, $buttons, $options);
    
        return $this->response;
    }
}
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\Cake\Controller
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
