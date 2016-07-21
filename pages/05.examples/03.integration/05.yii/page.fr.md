---
title: Le plugin Yii
menu: Le plugin Yii
template: jaxon
cache_enable: false
description: Cet exemple montre l'utilisation du [plugin Jaxon pour le framework Yii](https://github.com/jaxon-php/jaxon-yii?target=_blank).
---

Ce plugin initialise et configure la librairie Jaxon, et laisse au développeur le soin d'écrire les classes Jaxon pour son application.

La configuration de la librairie Jaxon se fait dans un fichier au format Yii, nommé `config/jaxon.php`.

Par défaut, le plugin Jaxon enregistre les classes dans le répertoire `jaxon/` de l'application Yii, avec le namespace `\Jaxon\App`.

#### Comment ça marche

Installer et configurer le plugin jaxon pour Yii, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-yii?target=_blank)

Dans le contrôleur du framework, insérer le code généré par la librairie dans la page en utilisant ses fonctions de gestion des vues

```php
use Yii;
use yii\web\Controller;

class DemoController extends Controller
{
    public function actionIndex()
    {
        $jaxon = Yii::$app->getModule('jaxon');
        // Call the Jaxon module
        $jaxon->register();

        return $this->render('index', array(
            'JaxonCss' => $jaxon->css(),
            'JaxonJs' => $jaxon->js(),
            'JaxonScript' => $jaxon->script(),
        ));
    }
}
```

Placer les fichiers Jaxon de l'application dans le répertoire `jaxon`

Dans cet exemple il y a deux fichiers `Bts.php` and `Pgw.php` dans le répertoire `jaxon/Test`.

```php
namespace Jaxon\App\Test;

class Bts extends \Jaxon\Yii\Controller
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

class Pgw extends \Jaxon\Yii\Controller
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
