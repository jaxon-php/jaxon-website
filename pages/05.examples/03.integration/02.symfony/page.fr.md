---
title: Le plugin Symfony
menu: Le plugin Symfony
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation du [plugin Jaxon pour le framework Symfony](https://github.com/jaxon-php/jaxon-symfony?target=_blank).

Le fichier de configuration, les classes et les vues [se trouvent ici](https://github.com/jaxon-php/jaxon-examples/tree/master/frameworks/symfony?target=_blank).

#### Comment ça marche

Installer et configurer le plugin jaxon pour Symfony, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-symfony?target=_blank).

Dans le contrôleur de l'application, insérer le code généré par Jaxon dans la page.

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
            'jaxonCss' => $jaxon->css(),
            'jaxonJs' => $jaxon->js(),
            'jaxonScript' => $jaxon->script()
        ]);
    }
}
```
