---
title: Les composants de pagination
menu: Composants de pagination
template: jaxon
---

Les composants de pagination affichent les contenus paginés et les liens de pagination correspondants.

Le composant de pagination est un composant d'UI, ce qui signifie qu'il va être attaché à un noeud du DOM.
Il possède un autre composant d'UI pour l'affichage des liens de pagination, et la méthode `Jaxon\attr()->pagination()` permet de définir dans les templates l'endoit où ils seront affichés.

```php
<div class="row">
    <!-- Pagination content component -->
    <div class="col-md-12" <?php
        echo Jaxon\attr()->bind(Jaxon\rq(PageComponent::class)) ?>>
    </div>
    <!-- Pagination links component -->
    <div class="col-md-12" <?php
        echo Jaxon\attr()->pagination(Jaxon\rq(PageComponent::class)) ?>>
    </div>
</div>
```

Note: le contenu du composant des liens est affiché uniquement si le nombre de pages est supérieur à 1.

#### Affichage de la pagination

Les composants de pagination héritent de la classe `Jaxon\App\PageComponent`, qui, comme les composants d'UI, les oblige a implémenter une fonction `public function html(): string|Stringable`.

La nouvelle méthode `currentPage()` renvoie le numéro de la page courante.

```php
    public function html():  string
    {
        return '<div>Showing page number ' . $this->currentPage() . '</div>';
    }
```

La classe `Jaxon\App\PageComponent` impose aussi l'implémentation des méthodes `protected function limit(): int` et `protected function count(): int`, qui doivent respectivement renvoyer le nombre maximal d'items par page, et le nombre d'items à paginer.

Enfin, la fonction qui affiche le contenu paginé peut être mise en place.

```php
    public function showPage(int $pageNumber)
    {
        // Get the paginator. This will also set the final page number value.
        $paginator = $this->paginator($pageNumber);
        // Render the page content.
        $this->render();
        // Render the pagination component.
        $paginator->render($this->rq()->showPage());
    }
```

#### Utilisation d'un `data bag`

Le trait `Jaxon\App\PageDatabagTrait` peut être utilisé pour conserver les paramètres de pagination dans un [data bag](../databags.html).
Cela permet par exemple lorsque l'utilisateur quitte et revient sur la page, de le repositionner sur le dernier numéro de page visité.

Le trait `Jaxon\App\PageDatabagTrait` impose l'implémentation des méthodes `protected function bagName(): string` et `protected function bagAttr(): string`, qui doivent respectivement renvoyer le nom du `data bag`, et la clé qui va stocker le numéro de page.

```php
/**
 * @databag content
 */
class PageContent extends \Jaxon\App\PageComponent
{
    use PageDatabagTrait;

   /**
    * @inheritDoc
    */
   protected function bagName(): string
   {
       return 'content';
   }

   /**
    * @inheritDoc
    */
   protected function bagAttr(): string
   {
       return 'page.number';
   }

   /**
    * @inheritDoc
    */
    protected function limit(): int
    {
        return 10;
    }
 
    /**
     * @inheritDoc
     */
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
        // Get the paginator. This will also set the final page number value.
        $paginator = $this->paginator($pageNumber);
        // Render the page content.
        $this->render();
        // Render the pagination component.
        $paginator->render($this->rq()->showPage(pm()->page()));
    }
}
```
