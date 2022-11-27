---
title: Les vues
menu: Les vues
template: jaxon
---

Jaxon fournit pour l'affichage des vues une API simple et unique, qui peut être utilisée avec différents moteurs de templates.

#### L'installation

Pour afficher les vues avec un moteur de template, il faut d'abord installer le package correspondant.
Des packages existent actuellement pour 6 moteurs de templates. Plusieurs peuvent être utilisés simultanément dans une application.

- [Twig](https://twig.sensiolabs.org) https://github.com/jaxon-php/jaxon-twig. Son identifiant est `twig`.
- [Smarty](http://www.smarty.net) https://github.com/jaxon-php/jaxon-smarty. Son identifiant est `smarty`.
- [Blade](https://laravel.com/docs/master/blade) https://github.com/jaxon-php/jaxon-blade. Son identifiant est `blade`.
- [Latte](https://latte.nette.org) https://github.com/jaxon-php/jaxon-latte. Son identifiant est `latte`.

Il faut ensuite déclarer les répertoires qui contiennent les templates, et les moteurs pour les afficher.

```php
jaxon()->di()->getViewManager()->addNamespace('ns', '/path/to/namespace', '.blade.php', 'blade');
```

L'appel `jaxon()->view()->render('ns::path/to/view')` va alors afficher le template `/path/to/namespace/path/to/view.blade.php` avec le moteur Blade.

#### Les variables

Les fonctions suivantes permettent de passer des variables aux vues.

La fonction `share()` rend une variable disponible dans toutes les vues.

```php
    jaxon()->view()->share('count', 5);
```

La fonction `set()` rend une variable disponible dans la prochaine vue à afficher. Elle peut être chaînée avec la fonction `render()`.

```php
    jaxon()->view()->set('count', 5)->set('current', 1)->render('ns::path/to/view');
```

La fonction `with()` ajoute une variable à la vue créée avec la fonction `render()`.

```php
    jaxon()->view()->render('ns::path/to/view')->with('count', 5)->with('current', 1);
```

Les variables peuvent aussi être passées dans un tableau en second paramètre de la fonction `render()`.

```php
    jaxon()->view()->render('ns::path/to/view', ['count' => 5, 'current' => 1]);
```

#### Ajouter un moteur de template

Pour ajouter un moteur de templates à Jaxon, il faut créer et déclarer une classe qui implémente l'interface `Jaxon\Contracts\View`.

```php
namespace Jaxon\Contracts;

use Jaxon\Utils\View\Store;

interface View
{
    /**
     * Add a namespace to the view renderer
     *
     * @param string        $sNamespace         The namespace name
     * @param string        $sDirectory         The namespace directory
     * @param string        $sExtension         The extension to append to template names
     *
     * @return void
     */
    public function addNamespace($sNamespace, $sDirectory, $sExtension = '');

    /**
     * Render a view
     *
     * @param Store         $store        A store populated with the view data
     *
     * @return string        The string representation of the view
     */
    public function render(Store $store);
}
```

```php
use Jaxon\Contracts\View as ViewContract;

class NewView implements ViewContract
{
}
```

La méthode `addNamespace()` sera appelée chaque fois qu'un répertoire est associé au moteur de template.
La méthode `render()` retourne le code HTML d'une vue. Elle prend en paramètre une instance de la classe `Jaxon\Utils\View\Store`, qui contient les données passées à la vue.

Après avoir défini la classe, il faut la déclarer avec l'appel suivant.

```php
jaxon()->di()->getViewManager()->addViewRenderer($myViewId, function(){
    return new NewView();
});
```

Le paramètre `$myViewId` est l'identifiant unique du nouveau moteur de template, à passer à l'appel à `jaxon()->di()->getViewManager()->addNamespace()`.

#### Dans le fichier de config

Les vues peuvent aussi être définies dans la section `app.views` de la configuration de Jaxon.

Chaque entrée de cette section est indexé par un identifiant unique, qui sera utilisé lors de l'affichage pour indiquer dans quel répertoire se trouve la vue.

Chaque entrée de cette section représente un répertoire, défini avec les informations suivantes:

- `directory` : le chemin complet du répertoire.
- `extension` : l'extension à ajouter aux vues du répertoire.
- `renderer` : l'identifiant du moteur de templates à utiliser pour afficher les vues du répertoire.

La configuration suivante définit un répertoire `/path/to/users/views` qui contient des templates Smarty.

```php
    'app' => [
        'views' => [
            'users' => [
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ]
        ]
    ],
```

Le code suivant affiche le template dans le fichier `/path/to/users/views/path/to/view.tpl` avec le moteur Smarty.

```php
use function Jaxon\jaxon;

$html = jaxon()->view()->render('users::path/to/view');
```

Si on définit dans la configuration un namespace par défaut, alors l'identifiant peut être omis dans l'appel.

```php
    'app' => [
        'views' => [
            'users' => [
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ]
        ],
        'options' => [
            'views' => [
                'default' => 'users',
            ]
        ]
    ],
```

```php
use function Jaxon\jaxon;

$html = jaxon()->view()->render('path/to/view');
```

#### La vue de pagination

Avec Jaxon, les liens de pagination peuvent être affichés avec n'importe quel moteur de templates (voir [la documentation des vues](../views)).

Pour personnaliser la pagination, il faut créer tous les templates de pagination dans un répertoire, puis l'indiquer dans la configuration des vues.

```php
        'views' => [
            'pagination' => [
                'directory' => '/chemin/vers/le/repertoire',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ],
        ],
```
