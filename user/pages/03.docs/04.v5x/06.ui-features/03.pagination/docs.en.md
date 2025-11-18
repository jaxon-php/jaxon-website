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

The `click` event on each link will be bound to a call to a request to a Jaxon class, with the corresponding parameters.
Therefore, parameters in pagination links are not named, and their position is important.

The `paginator()` method of the [Response object](../../requests/responses.html) creates a pagination object, which must then be associated with [a request to a function of a class](../../ui-features/call-factories.html), to generate the pagination links.

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

This can also be done fluently, using the `page()` method.

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

The position of the page number in the parameters of the paginated function is indicated by the call to `pm()->page()`. If it is not present, it will be automatically added to the end of the list of provided parameters.

#### Customizing Pagination

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
jaxon()->template()->pagination('/chemin/vers/le/repertoire/de/template');
```
