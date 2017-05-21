---
title: Le plugin CakePHP
menu: Le plugin CakePHP
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation du [plugin Jaxon pour le framework CakePHP](https://github.com/jaxon-php/jaxon-cake?target=_blank).

Le fichier de configuration, les classes et les vues [se trouvent ici](https://github.com/jaxon-php/jaxon-examples/tree/master/frameworks/cake?target=_blank).

#### Comment ça marche

Installer et configurer le plugin jaxon pour CakePHP, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-cake?target=_blank).

Dans le contrôleur de l'application, insérer le code généré par Jaxon dans la page.

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
