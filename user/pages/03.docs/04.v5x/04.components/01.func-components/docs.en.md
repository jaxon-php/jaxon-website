---
title: Functional components
menu: Functional components
template: jaxon
---

Functional components were called [Callable classes](../../../v4x/features/classes.html) in the previous versions of Jaxon.
They are classes whose public functions are exported to Javascript, so they can be called from the browser.

Functional components inherit from the `Jaxon\App\FuncComponent` class, which provides them with a set of utility functions.

The provided functions include [views](../../ui-features/views.html), [sessions](../../features/sessions.html), [file upload](../../features/upload.html), [logging](../../features/logging.html), data sharing ([databags](../databags.html) and [stash](../stash.html)), in addition to those described below.

#### Retrieve an instance of another class

The `cl()` method returns an instance of another registered Jaxon class. It takes the full name (with namespace) of the class as a parameter.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        // Call the method doB() of the ClassB class
        $this->cl(ClassB::class)->doB();
    }
}
```

#### The `Response` object

All the components have access to the same `Response` object, through their `response` attribute, which is automatically initialized by the library.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        $this->response->alert('ComponentA::doAB() called.');
        // Call the doB() method of this class
        $this->doB();
    }

    public function doB()
    {
        $this->response->alert('ComponentA::doB() called.');
        // Call the doA() method
        $this->doA();
        // Call the doB() method of class ClassB
        $this->cl(ClassB::class)->doB();
    }
}
```

```php
class ClassB extends \Jaxon\App\FuncComponent
{
    public function doB()
    {
        $this->response->alert('ClassB::doB() called.');
    }
}
```

#### Les fenêtres et alertes

Le trait `Jaxon\App\Dialog\DialogTrait` founit les méthodes `alert()` et `dialog()` qui affichent [les dialogues et les messages](../../ui-features/dialogs.html) dans la page.

```php
use Jaxon\App\Dialog\DialogTrait;

class ComponentA extends \Jaxon\App\FuncComponent
{
    use DialogTrait;

    public function doA()
    {
        $this->alert()->title('Information')->info('This is an information');
    }

    public function doB()
    {
        $title = 'Modal Dialog';
        $content = '<div>This is a modal dialog</div>';
        $buttons = [
            ['title' => 'Close', 'class' => 'btn btn-danger', 'click' => 'close'],
        ];
        $this->dialog()->show($title, $content, $buttons);
    }
}
```

#### The Request Factory

The `rq()` method returns a request to its calling class.
It provides a fluid interface that transforms a call to any of its method into a request to the same method, which can then be bound to an event on an element in the web page.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to an ajax call to the doB() method in this class
        $this->response->jq('#btn-a')->on('click', $this->rq()->doB());

        // Bind the click on the button with id "btn-b" to an ajax call to the doB() method in class ClassB
        $this->response->jq('#btn-b')->on('click', $this->rq(ClassB::class)->doB());
    }
}
```

The [request factory](../../ui-features/call-factories.html) will often be used in templates to define [event handlers](../../ui-features/templates.html).

#### The pagination

The `paginator()` method creates pagination links with calls to a method of a component.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    private function showPageContent($pageNumber)
    {
        // Build and display the paginated content.
        $this->response->assign('div2', 'innerHTML', "Showing page number $page");
    }

    public function showPage($pageNumber)
    {
        $itemsPerPage = 10;
        $totalItems = 150;
        $this->paginator($pageNumber, $itemsPerPage, $totalItems)
            ->page(function(int $page) {
                $this->showPageContent($page);
            })
            // Render the pagination links in the node with id "pagination".
            ->render($this->rq()->showPage(), 'pagination');
    }
}
```
