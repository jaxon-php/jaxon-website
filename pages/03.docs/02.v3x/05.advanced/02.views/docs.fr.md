---
title: Les vues
menu: Les vues
template: jaxon
---

Armada fournit pour l'affichage des vues une API simple et unique, qui peut être utilisée avec différents moteurs de templates.

#### L'installation

Pour afficher les vues avec un moteur de template, il faut d'abord installer le package correspondant.
Des packages existent actuellement pour 6 moteurs de templates.

- [Twig](https://twig.sensiolabs.org) https://github.com/jaxon-php/jaxon-twig. Son identifiant est `twig`.
- [Smarty](http://www.smarty.net) https://github.com/jaxon-php/jaxon-smarty. Son identifiant est `smarty`.
- [Blade](https://laravel.com/docs/master/blade) https://github.com/jaxon-php/jaxon-blade. Son identifiant est `blade`.
- [Dwoo](http://dwoo.org) https://github.com/jaxon-php/jaxon-dwoo. Son identifiant est `dwoo`.
- [Latte](https://latte.nette.org) https://github.com/jaxon-php/jaxon-latte. Son identifiant est `latte`.
- [RainTpl](https://feulf.github.io/raintpl) https://github.com/jaxon-php/jaxon-raintpl. Son identifiant est `raintpl`.

Plusieurs peuvent être utilisés simultanément dans une application Armada.

#### Les variables

Les fonctions suivantes permettent de passer des variables aux vues.

La fonction `share()` rend une variable disponible dans toutes les vues.

```php
    $this->view()->share('count', 5);
```

La fonction `set()` rend une variable disponible dans la prochaine vue à afficher. Elle peut être chaînée avec la fonction `render()`.

```php
    $this->view()->set('count', 5)->set('current', 1)->render('path/to/view');
```

La fonction `with()` ajoute une variable à la vue créée avec la fonction `render()`.

```php
    $this->view()->render('path/to/view')->with('count', 5)->with('current', 1);
```

Les variables peuvent aussi être passées dans un tableau en second paramètre de la fonction `render()`.

```php
    $this->view()->render('path/to/view', array('count' => 5, 'current' => 1));
```

#### Ajouter un moteur de template

Pour ajouter un moteur de templates à Armada, il faut créer une classe qui implémente l'interface `Jaxon\Sentry\Interfaces\View`, définie dans le package `jaxon-sentry`.

```php
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
    public function render(\Jaxon\Sentry\View\Store $store);
}
```

La méthode `addNamespace()` est appelée pour chaque répertoire associé au moteur de template dans la la configuration.
La méthode `render()` retourne le code HTML d'une vue. Elle prend en paramètre un objet de la classe `\Jaxon\Sentry\View\Store` qui contient les informations sur la vue.

Après avoir défini la classe, il faut l'enregistrer dans Armada avec l'appel suivant.

```php
jaxon()->armada()->addViewRenderer($myViewId, function(){
    return new View();
});
```

Le paramètre `$myViewId` est l'identifiant qui sera défini comme valeur de l'option `renderer` dans la configuration.
