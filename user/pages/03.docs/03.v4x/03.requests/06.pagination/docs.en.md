---
title: Pagination
menu: Pagination
template: jaxon
---

The pagination with Jaxon is different from the pagination with a classic web application, because while the application generates a list of links to different pages, Jaxon must generate a list of calls to a javascript function with different parameters.
For Jaxon, the parameters in pagination links are not named, and their position is important.

Here is an example of pagination links in a classic web application.
```html
<ul class="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="/items?page=2">2</a></li>
    <li><a class="page-numbers" href="/items?page=3">3</a></li>
    <li><a class="page-numbers" href="/items?page=4">4</a></li>
    <li><a class="page-numbers" href="/items?page=5">5</a></li>
</ul>
```

With Jaxon, we should have links more like this.
```html
<ul class="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(2)">2</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(3)">3</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(4)">4</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(5)">5</a></li>
</ul>
```

The `paginate()` ou `pg()` method allows, from a request, to generate the pagination links to a method of a Jaxon class.

```php
$pagination = rq('MyClass')->call('showPage', pm()->select('colorselect'), pm()->page())->paginate($currentPage, $itemsPerPage, $itemsTotal);
```

The position of the page number is indicated by the `pm()->page()` function. If it is not present in the call, it will be automatically added to the end of the parameter list.
The result is the HTML code to be inserted in the page.

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

#### Customizing the pagination

The pagination links are generated from templates, which by default are provided by the library: [https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination](https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination).

At the root of the directory, there is the `wrapper` template which wraps pagination links with the required HTML tags.
The `links` template variable contains the pagination links list, while the `prev` and `next` template variables respectively contain the link to the previous and the next pages.
The `prev` and `next` variables are empty if the corresponding link is not present.

In the `links` sub-directory, there is a template for each type of link.

- The `current` template prints the link to the current page.
- The `enabled` template prints the link to an active page.
- The `disabled` template prints the link to an inactive page.
- The `prev` template prints the link to the previous page.
- The `next` template prints the link to the next page.

In each template, the `text` variable contains the text to be printed, while the `call` variable contains the Jaxon call which shows the corresponding page.
The `call` variable is not available in the `disabled` template.

In order to customize the pagination, copy the templates to another directory and edit them.
Then, make the following call to setup the new directory.

```php
jaxon()->template()->pagination('/path/to/the/template/directory');
```
