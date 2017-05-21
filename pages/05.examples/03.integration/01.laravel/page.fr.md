---
title: Le plugin Laravel
menu: Le plugin Laravel
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation du [plugin Jaxon pour le framework Laravel](https://github.com/jaxon-php/jaxon-laravel?target=_blank).

Le fichier de configuration, les classes et les vues [se trouvent ici](https://github.com/jaxon-php/jaxon-examples/tree/master/frameworks/laravel?target=_blank).

#### Comment ça marche

Installer et configurer le plugin jaxon pour Laravel, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-laravel?target=_blank).

Dans le contrôleur de l'application, insérer le code généré par Jaxon dans la page.

```php
use LaravelJaxon;

class DemoController extends Controller
{
    public function index()
    {
        // Register the Jaxon classes
        LaravelJaxon::register();
        // Print the page
        return view('index', array(
            'JaxonCss' => LaravelJaxon::css(),
            'JaxonJs' => LaravelJaxon::js(),
            'JaxonScript' => LaravelJaxon::script()
        ));
    }
}
```
