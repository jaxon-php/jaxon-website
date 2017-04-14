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

La position du numéro de page est indiquée par la fonction `Jaxon\Request\Factory::page()`. S'il n'est pas présent dans l'appel, il sera automatiquement ajouté à la fin de la liste des paramètres.

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
    <div id="pagination-wrapper"><?php echo $pagination ?></div>
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
