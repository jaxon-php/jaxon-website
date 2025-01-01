---
title: Pagination components
menu: Pagination components
template: jaxon
---

Pagination components display paginated content and the corresponding pagination links.

The pagination component is a UI component, which means it will be attached to a DOM node.
It has another UI component for displaying pagination links, and the `Jaxon\attr()->pagination()` method allows to define in templates where they will be displayed.

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

Note: The content of the links component is displayed only if the number of pages is greater than 1.

#### Displaying pagination

Pagination components inherit from the `Jaxon\App\PageComponent` class, which, like UI components, requires them to implement a `public function html(): string|Stringable` function.

The new `currentPage()` method returns the current page number.

```php
    public function html():  string
    {
        return '<div>Showing page number ' . $this->currentPage() . '</div>';
    }
```

The `Jaxon\App\PageComponent` class also requires the implementation of the `protected function limit(): int` and `protected function count(): int` methods, which must respectively return the maximum number of items per page, and the number of items to paginate.

Finally, the function that displays paginated content can be implemented.

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

#### Using a `data bag`

The `Jaxon\App\PageDatabagTrait` trait can be used to store pagination settings in a [data bag](../databags.html).
This allows, for example, when a user leaves and returns to the page, to reposition him on the last page number visited.

The `Jaxon\App\PageDatabagTrait` trait requires the implementation of the `protected function bagName(): string` and `protected function bagAttr(): string` methods, which must return the name of the `data bag` and the key that will store the page number, respectively.

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
