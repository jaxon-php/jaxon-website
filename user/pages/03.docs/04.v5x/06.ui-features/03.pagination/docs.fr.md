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

Le numéro de page est placé dans un attribut HTML, et l'évènement `click` sur chaque lien génère une requête Ajax vers une classe Jaxon avec les paramètres requis.
Par conséquence, les paramètres dans les requêtes Ajax de pagination ne sont pas nommés, et leur position est importante.

#### La pagination avec un composant fonctionnel

La classe `Jaxon\App\FuncComponent` fournit une méthode `paginator()` qui crée les liens de pagination avec les appels vers une méthode d'un composant.
Elle prend en paramètres la page courante, le nombre d'éléments par page, le nombre total d'éléments à paginer, et renvoie un paginateur configuré avec ces valeurs.

```php
use function Jaxon\page;

class ComponentA extends \Jaxon\App\FuncComponent
{
    private function showPageContent(int $pageNumber)
    {
        // Build and display the paginated content in the node with id "pagination-content".
        $this->response()->html('pagination-content', "Showing page number $page");
    }

    public function showPage(int $pageNumber)
    {
        $itemsPerPage = 10;
        $totalItems = 150;
        $this->paginator($pageNumber, $itemsPerPage, $totalItems)
            ->page(function(int $page) {
                $this->showPageContent($page);
            })
            // Render the pagination links in the node with id "pagination-links".
            ->render($this->rq()->showPage(page()), 'pagination-links');
    }
}
```

La méthode `page()` du paginateur appelle la closure qu'elle reçoit en paramètre avec le numéro de page, qui peut avoir été corrigé.
La méthode `render()` reçoit en paramètres un appel vers la fonction à paginer, généré avec une `call factory`, et l'id du noeud du DOM où les liens de pagination doivent être affichés.

> Note: la position du numéro de page dans les paramètres de la fonction paginée est indiquée par l'appel à la fonction globale `page()`. S'il n'est pas présent, il sera automatiquement ajouté à la fin de la liste des paramètres fournis.

```php
<div class="row">
    <div class="col-md-12" id="pagination-content">
    </div>
    <div class="col-md-12" id="pagination-links">
    </div>
</div>
```

### Utilisation d'un composant de pagination

Les composants de pagination simplifient un peu plus la fonction.
Il hérite de la classe `Jaxon\App\PageComponent`, et définit des méthodes qui renvoient les données de pagination.
- La méthode `limit()` renvoie le nombre maximal d'éléments dans une page.
- La méthode `count()` renvoie le nombre total d'éléments à paginer.
- La méthode `html()` renvoie le contenu paginée. La méthode `currentPage()` fournie par la classe `Jaxon\App\PageComponent` donne le numéro de la page courante.

Un seul appel à la méthode `paginate()` fournie par la classe `Jaxon\App\PageComponent` est désormais nécessaire pour afficher à la fois le contenu paginé et les liens de pagination.

```php
use function Jaxon\page;

class PageComponent extends \Jaxon\App\PageComponent
{
    protected function limit(): int
    {
        return 10;
    }

    protected function count(): int
    {
        return 45;
    }

    public function html():  string
    {
        return '<div>Contenu de la page numéro ' . $this->currentPage() . '</div>';
    }

    public function showPage(int $pageNumber)
    {
        // Afficher le contenu paginé et mettre à jour les liens de pagination.
        $this->paginate($this->rq()->showPage(page()), $pageNumber);
    }
}
```

Dans le template, au lieu d'utiliser des id, les composants sont attachés aux noeuds du DOM.

```php
<div class="row">
    <!-- Contenu du composant de pagination -->
    <div class="col-md-12" <?php echo attr()->bind(rq(PageComponent::class)) ?>>
    </div>
    <!-- Contenu du composant des liens de pagination -->
    <div class="col-md-12" <?php echo attr()->pagination(rq(PageComponent::class)) ?>>
    </div>
</div>
```

#### Utilisation d'un `databag`

Le trait `Jaxon\App\PageDatabagTrait` peut être utilisé pour conserver les paramètres de pagination dans un [databag](../databags.html).
Cela permet par exemple lorsque l'utilisateur quitte et revient sur la page, de le repositionner sur le dernier numéro de page visité.

Le trait `Jaxon\App\PageDatabagTrait` requiert l'implémentation des méthodes `bagName()` et `bagAttr()`, qui doivent respectivement renvoyer le nom et la clé du `databag` qui stocke le numéro de page.

```php
use function Jaxon\page;

/**
 * @databag content
 */
class PageContent extends \Jaxon\App\PageComponent
{
    use PageDatabagTrait;

    protected function bagName(): string
    {
        return 'pagination.content';
    }

    protected function bagAttr(): string
    {
        return 'pagination.number';
    }

    protected function limit(): int
    {
        return 10;
    }
 
    protected function count(): int
    {
        return 150;
    }
 
    public function html():  string
    {
        return '<div>Showing page number ' . $this->currentPage() . '</div>';
    }

    public function showPage(int $pageNumber)
    {
        // Afficher le contenu paginé et mettre à jour les liens de pagination.
        $this->paginate($this->rq()->showPage(page()), $pageNumber);
    }
}
```

### La pagination avec l'objet Response

> Note: cette fonctionnalité a été supprimée dans la version [5.5.0](https://github.com/jaxon-php/jaxon-core/releases/tag/v5.5.0).

La méthode `paginator()` de [l'objet Response](../../requests/responses.html) crée un objet de pagination, qui doit ensuite être associée à [une requête vers une fonction d'une classe](../../ui-features/call-factories.html), pour générer les liens de pagination.

```php
use function Jaxon\pm;

class HelloWorld
{
    public function showPage(int $pageNumber)
    {
        $itemsPerPage = 10;
        $totalItems = 150;
        $response = jaxon()->getResponse();

        $paginator = $response->paginator($pageNumber, $itemsPerPage, $totalItems);
        // Display the paginated content
        $page = $paginator->currentPage();
        $this->response()->assign('page-content', 'innerHTML', "Showing page number $page");
        // Display the pagination links, in the DOM node with id "pagination"
        $paginator->render($this->rq()->showPage(pm()->page()), 'pagination');
    }
}
```

Cela peut également être fait de manière `fluent`, en utilisant la méthode `page()`.

```php
use function Jaxon\pm;

class HelloWorld
{
    public function showPage(int $pageNumber)
    {
        $itemsPerPage = 10;
        $totalItems = 150;
        $response = jaxon()->getResponse();

        $response
            ->paginator($pageNumber, $itemsPerPage, $totalItems)
            ->page(function(int $page) {
                // Display the paginated content
                $this->response()->assign('page-content', 'innerHTML', "Showing page number $page");
            })
            // Display the pagination links, in the DOM node with id "pagination"
            ->render($this->rq()->showPage(pm()->page()), 'pagination');
    }
}
```

### La pagination sans limite supérieure

Le paginateur de Jaxon utilise le nombre total d'éléments à paginer pour déterminer le numéro de la dernière page de la pagination.
Si l'application demande l'affichage d'un numéro de page supérieur à cette limite, le paginateur corrige le numéro, et sa méthode `currentPage()` renvoie celui de la dernière page.

> Note: le nombre total d'éléments est soit reçu en paramètre par le paginateur, soit renvoyé par la méthode `count()`.

Cependant, retrouver le nombre total d'éléments requiert l'exécution d'une opération (souvent une requête SQL) supplémentaire à chaque affichage de page.
Le développeur pour souhaiter faire l'économie de cette opération. Dans ce cas, il suffit de passer un nombre négatif au paginateur.
Il ne va plus vérifier la limite supérieure de numéro de page, et ne va plus afficher la dernière page dans les liens de pagination.

### Les options de pagination

Le paginateur de Jaxon fournit des fonctions pour changer le texte des boutons précédent et suivant.

Dans un composant fonctionnel, ces fonctions peuvent être appelées directement sur le paginateur, car on y a accès.

```php
        $this->paginator($pageNumber, $itemsPerPage, $totalItems)
            ->setPreviousText('Précédent')
            ->setNextText('Suivant')
            ->page(function(int $page) {
                $this->showPageContent($page);
            })
            // Render the pagination links in the node with id "pagination-links".
            ->render($this->rq()->showPage(page()), 'pagination-links');

```

Un composant de pagination définit plutôt une closure qui va recevoir le paginateur en paramètre.

```php
use Jaxon\App\Pagination\Paginator;

class PageComponent extends \Jaxon\App\PageComponent
{
    protected function setupComponent(): void
    {
        $this->paginatorSetup(function(Paginator $paginator) {
            $paginator->setPreviousText('Précédent')->setNextText('Suivant');
        });
    }
}
```

### Les templates de pagination

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
jaxon()->template()->pagination('/chemin/vers/le/repertoire/de/templates');
```
