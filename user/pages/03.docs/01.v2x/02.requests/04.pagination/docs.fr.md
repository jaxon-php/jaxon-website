---
title: La pagination
menu: La pagination
template: jaxon
---

La pagination avec Jaxon est différente de la pagination d'une application classique, car là où l'application génère une liste de liens vers des pages différentes, Jaxon doit générer une liste d'appels à une fonction javascript avec des paramètres différents.  
Pour Jaxon, les paramètres dans les liens de pagination ne sont pas nommés, et leur position est importante.

Voici un exemple de liens de pagination dans une application classique.
```html
<ul class="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="/items?page=2">2</a></li>
    <li><a class="page-numbers" href="/items?page=3">3</a></li>
    <li><a class="page-numbers" href="/items?page=4">4</a></li>
    <li><a class="page-numbers" href="/items?page=5">5</a></li>
</ul>               
```

Avec Jaxon, on devrait avoir plutôt ceci.
```html
<ul class="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(2)">2</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(3)">3</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(4)">4</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(5)">5</a></li>
</ul>                 
```

Pour faire de la pagination avec Jaxon, on appelle la méthode `paginate()` de la classe `\Jaxon\Request\Factory`.
```php
public function paginate($itemsTotal, $itemsPerPage, $currentPage, $method, ...)
```

Ses 3 premiers paramètres indiquent les options de pagination.
Son 4e paramètre indique la méthode (avec le nom de la classe) à appeler, et les suivants sont les paramètres de la requête.

La position du numéro de page est indiquée par la fonction `rq()->page()`. S'il n'est pas présent dans l'appel, il sera automatiquement ajouté à la fin de la liste des paramètres.

```php
$pagination = rq()->paginate(25, 10, 1, 'MyClass.showPage', rq()->select('colorselect'), rq()->page());
```

```html
<div class="content">
    <div id="color">
        <select class="form-control" id="colorselect" name="colorselect">
            <option value="black" selected="selected">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>
    </div>
    <div id="pagination-wrapper"><?= $pagination ?></div>
</div>
```

Dans une classe Jaxon, le trait `Jaxon\Request\Traits\Factory` fournit une méthode `paginate` qui crée les liens de pagination à partir du nom de la méthode, mais sans le nom de la classe.

```php
class MyClass
{
    use \Jaxon\Request\Traits\Factory;

    public function showPage($color, $currentPage)
    {
        $pagination = $this->paginate(25, 10, $currentPage, 'showPage', rq()->select('colorselect'), rq()->page());
        $response->assign('pagination-wrapper', 'innerHTML', $pagination);
        return $response;
    }
}
```

#### Personnalisation de la pagination

Les liens de pagination de Jaxon sont générés à partir de templates, qui par défaut sont fournis par la librairie : [https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination](https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination).

A la racine du répertoire, il y a le template `wrapper`, qui positionne les liens de pagination et les balises HTML qui les entourent.
La variable de template `links` contient la liste des liens de pagination, tandis que les variables `prev` et `next` contiennent respectivement les liens vers les pages précédente et suivante.
Les variables `prev` et `next` sont vides si le lien correspondant est absent.

Dans le sous-répertoire `links`, il y a un template pour chaque type de lien:

- Le template `current` affiche le lien vers la page courante.
- Le template `enabled` affiche un lien vers une page active.
- Le template `disabled` affiche un lien vers une page inactive.
- Le template `prev` affiche le lien vers la page précédente.
- Le template `next` affiche le lien vers la page suivante.

Dans chaque template, la variable `text` contient le texte à afficher, et la variable `call` contient l'appel Jaxon pour afficher la page correspondante.
La variable `call` n'est pas disponible dans le template `disabled`.

Pour personnaliser la pagination, il faut copier tous les templates vers un autre répertoire, et les modifier.
Ensuite, configurer le nouveau répertoire avec l'appel suivant.

```php
jaxon()->setPaginationDir('/chemin/vers/le/repertoire');
```
