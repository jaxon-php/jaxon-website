---
title: Pagination
menu: Pagination
template: jaxon
---

Pagination with Jaxon is different from pagination in a typical application, because where the application generates a list of links to different pages, Jaxon must generate a list of calls to a javascript function with different parameters.

Here is an example of pagination links in a typical application.

```html
<ul class="pagination" id="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="/items?page=2">2</a></li>
    <li><a class="page-numbers" href="/items?page=3">3</a></li>
    <li><a class="page-numbers" href="/items?page=4">4</a></li>
    <li><a class="page-numbers" href="/items?page=5">5</a></li>
</ul>
```

Jaxon instead produces a result more like this.

```html
<ul class="pagination" id="pagination">
    <li class="page-item active"><a class="page-link" role="link">1</a></li>
    <li class="page-item enabled" data-page="2"><a class="page-link" role="link">5</a></li>
    <li class="page-item enabled" data-page="3"><a class="page-link" role="link">5</a></li>
    <li class="page-item enabled" data-page="4"><a class="page-link" role="link">5</a></li>
    <li class="page-item enabled" data-page="5"><a class="page-link" role="link">5</a></li>
</ul>
```

The page number is placed in an HTML attribute, and the `click` event on each link generates an Ajax request to a Jaxon class with the required parameters.
Therefore, parameters in pagination Ajax requests are not named, and their position is important.

### Pagination with a functional component

The `Jaxon\App\FuncComponent` class provides a `paginator()` method which creates pagination links with calls to a method of a component.
It takes as parameters the current page, the number of items per page, the total number of items to paginate, and returns a paginator configured with these values.

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

The `page()` method of the paginator calls the closure it receives as a parameter with the page number, which may have been corrected.
The `render()` method receives as parameters a call to the function to be paginated, generated with a `call factory`, and the id of the DOM node where the pagination links should be displayed.

> Note: the position of the page number in the parameters of the paginated function is indicated by the call to the global function `page()`. If it is not present, it will be automatically added to the end of the list of provided parameters.

```php
<div class="row">
    <div class="col-md-12" id="pagination-content">
    </div>
    <div class="col-md-12" id="pagination-links">
    </div>
</div>
```

### Using a pagination component

The pagination components further simplify the feature.
They inherit from the `Jaxon\App\PageComponent` class, and implement functions that provide pagination information.
- The `limit()` method returns the maximum number of items on a page.
- The `count()` fmethod returns the total number of items to paginate.
- The `html()` method returns the paginated content. The `currentPage()` method provided by the `Jaxon\App\PageComponent` class gives the current page number.

Only a single call to the `paginate()` method provided by the `Jaxon\App\PageComponent` class is now required to display both the paginated content and the pagination links.

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
        return '<div>Content of page number ' . $this->currentPage() . '</div>';
    }

    public function showPage(int $pageNumber)
    {
        // Display paginated content and update pagination links.
        $this->paginate($this->rq()->showPage(page()), $pageNumber);
    }
}
```

In the template, instead of using ids, the components are attached to DOM nodes.

```php
<div class="row">
    <!-- Pagination content component -->
    <div class="col-md-12" <?php echo attr()->bind(rq(PageComponent::class)) ?>>
    </div>
    <!-- Pagination links component -->
    <div class="col-md-12" <?php echo attr()->pagination(rq(PageComponent::class)) ?>>
    </div>
</div>
```

#### Using a `databag`

The `Jaxon\App\PageDatabagTrait` trait can be used to store pagination settings in a [databag](../databags.html).
This allows, for example, when a user leaves and returns to the page, to reposition him on the last page number visited.

The `Jaxon\App\PageDatabagTrait` trait requires the implementation of the `bagName()` and `bagAttr()` methods, which respectively must return the name and key of the `databag` which stores the page number.

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
        // Display paginated content and update pagination links.
        $this->paginate($this->rq()->showPage(page()), $pageNumber);
    }
}
```

### Pagination with the Response object

> Note: this feature was removed in the [5.5.0 release](https://github.com/jaxon-php/jaxon-core/releases/tag/v5.5.0).

The `paginator()` method of the [Response object](../../requests/responses.html) creates a pagination object, which must then be associated with [a request to a function of a class](../../ui-features/call-factories.html), to generate the pagination links.

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

This can also be done fluently, using the `page()` method.

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

### Pagination without upper limit

The Jaxon paginator uses the total number of items to be paginated to determine the last page number.
If the application requests a page number higher than this limit, the paginator adjusts the number, and its `currentPage()` method returns the last page number.

> Note: the total number of elements is either received as a parameter by the paginator, or returned by the `count()` method.

However, retrieving the total number of items requires executing an additional operation (often an SQL query) each time the page is displayed.
The developer may wish to avoid this operation. In this case, the paginator simply needs to be passed a negative number.
It will then no longer check the upper limit of the page number, and will no longer display the last page in the pagination links.

### The pagination options

The Jaxon paginator provides functions for changing the text of the previous and next buttons.

In a functional component, these functions can be called directly on the paginator, as it is accessible there.

```php
        $this->paginator($pageNumber, $itemsPerPage, $totalItems)
            ->setPreviousText('Previous')
            ->setNextText('Next')
            ->page(function(int $page) {
                $this->showPageContent($page);
            })
            // Render the pagination links in the node with id "pagination-links".
            ->render($this->rq()->showPage(page()), 'pagination-links');

```

A pagination component instead defines a closure that will receive the paginator as a parameter.

```php
use Jaxon\App\Pagination\Paginator;

class PageComponent extends \Jaxon\App\PageComponent
{
    protected function setupComponent(): void
    {
        $this->paginatorSetup(function(Paginator $paginator) {
            $paginator->setPreviousText('Previous')->setNextText('Next');
        });
    }
}
```

### The pagination templates

Pagination links are generated from templates, which by default are provided by the library: [https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination](https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination).

At the root of the directory, there is the `wrapper` template, which positions the pagination links and the HTML tags that surround them.
The `links` template variable contains the list of pagination links, while the `prev` and `next` variables contain the links to the previous and next pages, respectively.
The `prev` and `next` variables are empty if the corresponding link is absent.

In the `links` subdirectory, there is a template for each type of link:

- The `current` template displays the link to the current page.
- The `enabled` template displays a link to an active page.
- The `disabled` template displays a link to an inactive page.

In each template, the `text` variable contains the text to display, and the `page` variable contains the page number.

To customize pagination, copy all the templates to another directory and modify them.
Then configure the new directory with the following call.

```php
jaxon()->template()->pagination('/path/to/the/templates/dir');
```
