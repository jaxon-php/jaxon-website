---
title: Pagination
menu: Pagination
template: jaxon
---

The pagination with Jaxon is different from the pagination with a classic web application, because where the application generates a list of links to different pages, Jaxon must generate a list of calls to a javascript function with different parameters.  
For Jaxon, the parameters in pagination links are not named, and their position is important.

Here is an example of pagination links in a classic web application.
```html
<div class="pagination">
    <span class="page-numbers current">1</span>
    <a class="page-numbers" href="/items?page=2">2</a>
    <a class="page-numbers" href="/items?page=3">3</a>
    <a class="page-numbers" href="/items?page=4">4</a>
    <a class="page-numbers" href="/items?page=5">5</a>
</div>               
```

With Jaxon, we should have links more like this.
```html
<div class="pagination">
    <span class="page-numbers current">1</span>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(2)">2</a>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(3)">3</a>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(4)">4</a>
    <a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(5)">5</a>
</div>                 
```

The `paginate()` method of the `\Jaxon\Request\Factory` class is used to implement pagination with Jaxon.
```php
public function paginate($itemsTotal, $itemsPerPage, $currentPage, $method, ...)
```

His fourth parameter indicates the method (with the name of the class) to call, and the following are the request parameters.
The position of the page number is indicated by the `jr::page()` function. If it is not present in the call, it will be automatically added to the end of the parameter list.

In a Jaxon class, the `\Jaxon\Request\FactoryTrait` trait also provides a `paginate()` method which creates pagination links from the method name, but without the name of the class.
```php
public function paginate($itemsTotal, $itemsPerPage, $currentPage, $method, ...)
```

Example.
```php
<?php
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
