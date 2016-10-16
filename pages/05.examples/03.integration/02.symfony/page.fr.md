---
title: Le plugin Symfony
menu: Le plugin Symfony
template: jaxon
cache_enable: false
description: Cet exemple montre l'utilisation du [plugin Jaxon pour le framework Symfony](https://github.com/jaxon-php/jaxon-symfony?target=_blank).
---

Ce plugin initialise et configure la librairie Jaxon, et laisse au développeur le soin d'écrire les classes Jaxon pour son application.

La configuration de la librairie Jaxon se fait dans un fichier au format Yaml, nommé `app/config/jaxon.yml`.
Un exemple de fichier de configuration est [disponible en ligne](https://github.com/jaxon-php/jaxon-examples/blob/master/frameworks/symfony/app/config/jaxon.yml?target=_blank).

Par défaut, le plugin Jaxon enregistre les classes dans le répertoire `src/Jaxon/App/` de l'application Symfony, avec le namespace `\Jaxon\App`.

#### Comment ça marche

Installer et configurer le plugin jaxon pour Symfony, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-symfony?target=_blank)

Dans le contrôleur du framework, insérer le code généré par la librairie dans la page en utilisant ses fonctions de gestion des vues

```php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DemoController extends Controller
{
    public function indexAction(Request $request)
    {
        // Register the Jaxon classes
        $jaxon = $this->get('jaxon.ajax');
        $jaxon->register();
        // Print the page
        return $this->render('demo/index.html.twig',
            'jaxon_css' => $jaxon->css(),
            'jaxon_js' => $jaxon->js(),
            'jaxon_script' => $jaxon->script()
        ]);
    }
}
```

Placer les fichiers Jaxon de l'application dans le répertoire `src/Jaxon/App`

Dans cet exemple il y a deux fichiers `Bts.php` and `Pgw.php` dans le répertoire `src/Jaxon/App/Test`.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\AjaxBundle\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div2', 'innerHTML', $text);
        $this->response->toastr->success("div2 text is now $text");
    
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
```

```php
namespace Jaxon\App\Test;

class Pgw extends \Jaxon\AjaxBundle\Controller
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';
    
        $this->response->assign('div1', 'innerHTML', $text);
        $this->response->toastr->success("div1 text is now $text");
    
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
```
