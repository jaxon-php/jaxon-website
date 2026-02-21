---
title: The three types of components
menu: Types of components
template: jaxon
---

A component in the Jaxon library is a class that can process Ajax requests received by the application and return a response, or display HTML content in a portion of the page.

A component will very often (but not always) be [exported from PHP to JavaScript](../../registrations/namespaces.html).
A JavaScript object is then created and inserted into the page, and a call to a function of this object in the browser automatically executes the same function in the PHP component on the server.

Three types of components can be defined in a Jaxon application:
- Functional components, which only provide functions for processing Ajax requests;
- UI components, which can also be attached to a DOM node and display its content;
- The pagination components, which display paginated content and pagination links.

The different types of components are described in more detail in the following sections, and their functions are presented [on this page](../../features.html).

### Functional components

Functional components were called [Callable classes](../../../v4x/features/classes.html) in the previous versions of Jaxon.

When a functional component is exported as JavaScript, its public functions can be called from a browser within an Ajax request.
Several other components can then be called sequentially to process the Ajax request.
Each of these components can then execute functions and [add actions to a response](../../features/responses.html), thus defining the operations to be performed on the page in response to the request.

Functional components inherit from the `Jaxon\App\FuncComponent` class, which provides them with a [set of functions](../../features.html).

### UI components

UI components are a new addition in Jaxon version 5.

They have the same functions as [functional components](../func-components.html), but in addition they can be attached to a DOM node.
They will then be used to manage the content of this node.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
</div>
```

A component can also be attached to a node dynamically.

```php
$this->response()->bind('element-id', rq(UiComponent::class));
```

UI components inherit from the `Jaxon\App\NodeComponent` class.
They can implement a `public function html(): string|Stringable` function that returns the contents of the attached node.

```php
class UiComponent extends \Jaxon\App\NodeComponent
{
    public function html(): string
    {
        return '<div>UI component content</div>';
    }
}
```

> Note: The `html()` method of a UI component is not exported to Javascript.

#### Render a component

The UI component has a `render()` function, which will be called to update the contents of the attached node, in a method of the same component, or of another component.

```php
class UiComponent extends \Jaxon\App\NodeComponent
{
    public function html(): string
    {
        return '<div>UI component content</div>';
    }

    public function doA()
    {
        // Apply the processing, then display the component
        // ...
        $this->render();
    }
}
```

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doB()
    {
        // Apply the processing, then display the component
        // ...
        $this->cl(UiComponent::class)->render();
    }
}
```

> Note: the `render()` method of a UI component can be exported as Javascript ([see the `export` option](../../registrations/options.html)), and can therefore be called from the browser or bound to UI events.

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        $this->response()->jq('#btn-refresh')
            ->on('click', $this->rq(UiComponent::class)->render());
    }
}
```

or in a template.

```php
<button type="button" class="btn btn-primary" <?php echo attr()
    ->click(rq(UiComponent::class)->render()) ?>>Clear</button>
```

The `Jaxon\App\ViewRenderer` trait adds the `protected function renderView(string $sViewName, array $aViewData = []): void` method to the UI component, which directly displays a template without calling the `html()` method.
The `protected function setViewPrefix(string $sViewPrefix)` method in this trait defines a prefix to apply to templates displayed with the `renderView()` method.

#### The other functions of UI components

The `public function clear(): void` function removes the inner contents of the attached node from the page.

The `public function visible(bool $bVisible): void` function, depending on the boolean parameter it receives, displays or hides the attached node, without modifying its contents.

The `protected function before(): void` and `protected function after(): void` functions are called respectively before and after the component is displayed in the `render()` function.
They are generally used to prepare or complete the display of the component, either by fetching data or by displaying other components.

> Note: the `clear()` and `visible()` methods of a UI component can be exported as Javascript ([see the `export` option](../../registrations/options.html)), and can therefore be called from the browser or bound to UI events.

### The pagination components

Pagination components display [paginated content and the corresponding pagination links](../../ui-features/pagination.html).

The pagination component is a UI component, which means it will be attached to a DOM node.
It also has another UI component, automatically created by the library, for displaying pagination links.
The `attr()->pagination()` method displays this component in the templates.

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

> Note: The content of the pagination links component is displayed only if the number of pages is greater than 1.

#### Pagination information

Pagination components inherit from the `Jaxon\App\PageComponent` class, and must implement functions that provide pagination information.
- The `protected function limit(): int` function returns the maximum number of items on a page.
- The `protected function count(): int` function returns the total number of items to paginate.

As with UI components, the `public function html(): string|Stringable` returns the HTML code to be displayed on the page.
The `currentPage()` method provided by the `Jaxon\App\PageComponent` class returns the current page number.

```php
    public function html(): string
    {
        return '<div>Content of page number ' . $this->currentPage() . '</div>';
    }
```

Finally, a pagination component must have a public method to paginate.
This method must accept the page number, an integer, as one of its parameters.

```php
use function Jaxon\page;

    public function showPage(int $pageNumber)
    {
        // Display paginated content and update pagination links.
        $this->paginate($this->rq()->showPage(page()), $pageNumber);
    }
```

In Jaxon versions prior to `5.4.0`, the code is different.
The `paginate()` function actually implements the same three calls.

```php
use function Jaxon\je;

    public function showPage(int $pageNumber)
    {
        // Get the paginator. This will also set the final page number value.
        $paginator = $this->paginator($pageNumber);
        // Render the paginated content.
        $this->render();
        // Render the pagination links.
        $paginator->render($this->rq()->showPage(je()->rd()->page()));
    }
```

The paginated function therefore uses two parameters: the page number, which usually comes from the Ajax call to the function, and a [call factory](../../ui-features/call-factories.html) that returns an Ajax call to itself.

Here is the minimum code required in a pagination component.

```php
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
