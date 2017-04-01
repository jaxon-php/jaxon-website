---
title: La pagination
menu: La pagination
template: jaxon
---

La pagination avec Jaxon est différente de la pagination d'une application classique, car là où l'application génère une liste de liens vers des pages différentes, Jaxon doit générer une liste d'appels à une fonction javascript avec des paramètres différents.  
Pour Jaxon, les paramètres dans les liens de pagination ne sont pas nommés, et leur position est importante.

Voici un exemple de liens de pagination dans une application classique.
```html
<div class="pagination">
    <span class="page-numbers current">1</span>
    <a class="page-numbers" href="/items?page=2">2</a>
    <a class="page-numbers" href="/items?page=3">3</a>
    <a class="page-numbers" href="/items?page=4">4</a>
    <a class="page-numbers" href="/items?page=5">5</a>
</div>               
```

Avec Jaxon, on devrait avoir plutôt ceci.
```html
<div class="pagination">
    <span class="page-numbers current">1</span>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(2)">2</a>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(3)">3</a>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(4)">4</a>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(5)">5</a>
</div>                 
```

Pour mettre en oeuvre la pagination avec Jaxon, on appelle la méthode `paginate()` de la classe `\Jaxon\Request\Factory`.
```php
public function paginate($itemsTotal, $itemsPerPage, $currentPage, $method, ...)
```

Son 4e paramètre indique la méthode (avec le nom de la classe) à appeler, et les suivants sont les paramètres de la requête.
La position du numéro de page est indiquée par la fonction `jr::page()`. S'il n'est pas présent dans l'appel, il sera automatiquement ajouté à la fin de la liste des paramètres.

Dans une classe Jaxon, le trait `Jaxon\Request\FactoryTrait` fournit également une méthode `paginate` qui crée les liens de pagination à partir du nom de la méthode, mais sans le nom de la classe.
```php
public function paginate($itemsTotal, $itemsPerPage, $currentPage, $method, ...)
```

Exemple.
```php
<?php
use Jaxon\Jaxon;
use Jaxon\Request\Factory as jr;
use Jaxon\Response\Response;

class MyClass
{
    use \Jaxon\Request\FactoryTrait;

    public function showPage($currentPage, $paginationText)
    {
        // Function body
        $response = new Response;

        // Pagination
        $itemsTotal = 45;
        $itemsPerPage = 10;
        $pagination = $this->paginate($itemsTotal, $itemsPerPage, $currentPage, 'showPage', jr::page(), jr::html('pagination-text'));
        $response->assign('pagination-text', 'innerHTML', $paginationText);
        $response->assign('pagination-content', 'innerHTML', $pagination);
        return $response;
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::CALLABLE_OBJECT, $myObject);

// Pagination
$itemsTotal = 45;
$itemsPerPage = 10;
$currentPage = 1;
// Requête
$pagination = jr::paginate($itemsTotal, $itemsPerPage, $currentPage, 'MyClass.showPage', jr::page(), jr::html('pagination-text'));
?>

<div class="content">
    <div id="pagination-text">
        Jaxon Pagination
    </div>
    <div id="pagination-content">
        <?php echo $pagination ?>
    </div>
</div>
```
