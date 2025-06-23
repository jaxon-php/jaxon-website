---
title: La pagination
menu: La pagination
template: jaxon
---

La pagination avec Jaxon est différente de la pagination d'une application classique, car là où l'application génère une liste de liens vers des pages différentes, Jaxon doit générer une liste d'appels à une fonction javascript avec des paramètres différents.

Voici un exemple de liens de pagination dans une application classique.

```html
<ul class="pagination" id="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="/items?page=2">2</a></li>
    <li><a class="page-numbers" href="/items?page=3">3</a></li>
    <li><a class="page-numbers" href="/items?page=4">4</a></li>
    <li><a class="page-numbers" href="/items?page=5">5</a></li>
</ul>
```

Jaxon produit plutôt un résultat semblable à celui-ci.

```html
<ul class="pagination" id="pagination">
    <li class="page-item active"><a class="page-link" role="link">1</a></li>
    <li class="page-item enabled" data-page="2"><a class="page-link" role="link">5</a></li>
    <li class="page-item enabled" data-page="3"><a class="page-link" role="link">5</a></li>
    <li class="page-item enabled" data-page="4"><a class="page-link" role="link">5</a></li>
    <li class="page-item enabled" data-page="5"><a class="page-link" role="link">5</a></li>
</ul>
```

L'évènement `click` sur chaque lien sera lié à l'appel d'une requête vers une class Jaxon avec les paramètres correspondants.
Par conséquence, les paramètres dans les liens de pagination ne sont pas nommés, et leur position est importante.

La méthode `paginator()` de [l'objet Response](../../requests/responses.html) crée un objet de pagination, qui doit ensuite être associée à [une requête vers une fonction d'une classe](../../ui-features/call-factories.html), pour générer les liens de pagination.

```php
class HelloWorld
{
    public function showPage($pageNumber)
    {
        $itemsPerPage = 10;
        $totalItems = 150;
        $response = jaxon()->getResponse();

        $paginator = $response->paginator($pageNumber, $itemsPerPage, $totalItems);
        // Display the paginated content
        $page = $paginator->currentPage();
        $this->response->assign('page-content', 'innerHTML', "Showing page number $page");
        // Display the pagination links, in the DOM node with id "pagination"
        $paginator->render($this->rq()->showPage(pm()->page()), 'pagination');
    }
}
```

Cela peut également être fait de manière `fluent`, en utilisant la méthode `page()`.

```php
class HelloWorld
{
    public function showPage($pageNumber)
    {
        $itemsPerPage = 10;
        $totalItems = 150;
        $response = jaxon()->getResponse();

        $response
            ->paginator($pageNumber, $itemsPerPage, $totalItems)
            ->page(function(int $page) {
                // Display the paginated content
                $this->response->assign('page-content', 'innerHTML', "Showing page number $page");
            })
            // Display the pagination links, in the DOM node with id "pagination"
            ->render($this->rq()->showPage(pm()->page()), 'pagination');
    }
}
```

La position du numéro de page dans les paramètres de la fonction paginée est indiquée par l'appel à `pm()->page()`. S'il n'est pas présent, il sera automatiquement ajouté à la fin de la liste des paramètres fournis.

#### Personnalisation de la pagination

Les liens de pagination sont générés à partir de templates, qui par défaut sont fournis par la librairie : [https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination](https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination).

A la racine du répertoire, il y a le template `wrapper`, qui positionne les liens de pagination et les balises HTML qui les entourent.
La variable de template `links` contient la liste des liens de pagination, tandis que les variables `prev` et `next` contiennent respectivement les liens vers les pages précédente et suivante.
Les variables `prev` et `next` sont vides si le lien correspondant est absent.

Dans le sous-répertoire `links`, il y a un template pour chaque type de lien:

- Le template `current` affiche le lien vers la page courante.
- Le template `enabled` affiche un lien vers une page active.
- Le template `disabled` affiche un lien vers une page inactive.

Dans chaque template, la variable `text` contient le texte à afficher, et la variable `page` contient le numéro de page.

Pour personnaliser la pagination, il faut copier tous les templates vers un autre répertoire, et les modifier.
Ensuite, configurer le nouveau répertoire avec l'appel suivant.

```php
jaxon()->template()->pagination('/chemin/vers/le/repertoire/de/template');
```
