---
title: Le plugin Yii
menu: Le plugin Yii
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation du [plugin Jaxon pour le framework Yii](https://github.com/jaxon-php/jaxon-yii?target=_blank).

Le fichier de configuration, les classes et les vues [se trouvent ici](https://github.com/jaxon-php/jaxon-examples/tree/master/frameworks/yii?target=_blank).

#### Comment ça marche

Installer et configurer le plugin jaxon pour Yii, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-yii?target=_blank).

Dans le contrôleur de l'application, insérer le code généré par Jaxon dans la page.

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
