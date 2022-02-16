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
- [Dwoo](http://dwoo.org) https://github.com/jaxon-php/jaxon-dwoo. Son identifiant est `dwoo`.
- [Latte](https://latte.nette.org) https://github.com/jaxon-php/jaxon-latte. Son identifiant est `latte`.
- [RainTpl](https://feulf.github.io/raintpl) https://github.com/jaxon-php/jaxon-raintpl. Son identifiant est `raintpl`.

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
