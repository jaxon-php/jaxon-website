---
title: Le plugin CodeIgniter
menu: Le plugin CodeIgniter
template: jaxon
cache_enable: false
description: Cet exemple montre l'utilisation du [plugin Jaxon pour le framework CodeIgniter](https://github.com/jaxon-php/jaxon-codeigniter?target=_blank).
---

Ce plugin initialise et configure la librairie Jaxon, et laisse au développeur le soin d'écrire les classes Jaxon pour son application.

La configuration de la librairie Jaxon se fait dans un fichier au format CodeIgniter, nommé `config/jaxon.php`.

Par défaut, le plugin Jaxon enregistre les classes dans le répertoire `application/jaxon` de l'application CodeIgniter, avec le namespace `\Jaxon\App`.

#### Comment ça marche

Installer et configurer le plugin jaxon pour CodeIgniter, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-codeigniter?target=_blank)

Dans le contrôleur du framework, insérer le code généré par la librairie dans la page en utilisant ses fonctions de gestion des vues

```php
class Demo extends Jaxon_Controller
{
    public function index()
    {
        // Register the Jaxon classes
        $this->jaxon->register();
        // Print the page
        $this->load->library('parser');
        $this->parser->parse('index', array(
            'JaxonCss' => $this->jaxon->css(),
            'JaxonJs' => $this->jaxon->js(),
            'JaxonScript' => $this->jaxon->script()
        ));
    }
}
```

Placer les fichiers Jaxon de l'application dans le répertoire `application/jaxon`

Dans cet exemple il y a deux fichiers `Bts.php` and `Pgw.php` dans le répertoire `application/jaxon/Test`.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\CI\Controller
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

class Pgw extends \Jaxon\CI\Controller
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
