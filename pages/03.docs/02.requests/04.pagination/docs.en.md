---
title: Pagination
menu: Pagination
template: jaxon
---

The pagination with Jaxon is different from the pagination with a classic web application, because where the application generates a list of links to different pages, Jaxon must generate a list of calls to a javascript function with different parameters.  
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

The `paginate()` method of the `\Jaxon\Request\Factory` class is used to implement pagination with Jaxon.
```php
public function paginate($itemsTotal, $itemsPerPage, $currentPage, $method, ...)
```

Its first 3 parameters indicate the pagination options.
Its fourth parameter indicates the method (with the name of the class) to call, and the following are the request parameters.

The position of the page number is indicated by the `Jaxon\Request\Factory::page()` function. If it is not present in the call, it will be automatically added to the end of the parameter list.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;
use Jaxon\Request\Factory as rq;

class MyClass
{
    public function showPage($color, $currentPage)
    {
        // Function body
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::CALLABLE_OBJECT, $myObject);

$pagination = rq::paginate(25, 10, 1, 'MyClass.showPage', rq::select('colorselect'), rq::page());
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

In a Jaxon class, the `\Jaxon\Request\Traits\Factory` trait also provides a `paginate()` method which creates pagination links from the method name, but without the name of the class.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;
use Jaxon\Request\Factory as rq;

class MyClass
{
    use \Jaxon\Request\Traits\Factory;

    public function showPage($color, $currentPage)
    {
        $response = new Response;
        $pagination = $this->paginate(25, 10, $currentPage, 'showPage', rq::select('colorselect'), rq::page());
        $response->assign('pagination-wrapper', 'innerHTML', $pagination);
        return $response;
    }
}
```
