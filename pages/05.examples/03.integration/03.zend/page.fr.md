---
title: Le plugin Zend
menu: Le plugin Zend
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation du [plugin Jaxon pour le Zend Framework](https://github.com/jaxon-php/jaxon-zend?target=_blank).

Le fichier de configuration, les classes et les vues [se trouvent ici](https://github.com/jaxon-php/jaxon-examples/tree/master/frameworks/zend?target=_blank).

#### Comment ça marche

Installer et configurer le plugin jaxon pour Zend, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-zend?target=_blank).

Dans le contrôleur de l'application, insérer le code généré par Jaxon dans la page.

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
