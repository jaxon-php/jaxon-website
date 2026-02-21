---
title: The component features
menu: Component features
template: jaxon
---

The [base classes for Jaxon components](../types.html) provide a wide range of functions, including [views](../../ui-features/views.html), [sessions](../../features/sessions.html), [file upload](../../features/upload.html), [logging](../../features/logging.html), data sharing (with [databags](../databags.html) and [stash](../stash.html)).

In addition to those above, the other component features are described below.

#### Call another component

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
        $this->response()->alert('ComponentA::doAB() called.');
        // Call the doB() method of this class
        $this->doB();
    }

    public function doB()
    {
        $this->response()->alert('ComponentA::doB() called.');
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
        $this->response()->alert('ClassB::doB() called.');
    }
}
```

#### The `NodeResponse` object

The `Jaxon\App\NodeComponent` class has a `node()` method that returns a special response, which is bound to the attached node.

The [page content and style edition functions](../../features/responses.html) in this object no longer have the `string $sTarget` parameter, as they will only apply on the attached node.

#### The Request Factory

The `rq()` method returns a request to its calling class.
It provides a fluid interface that transforms a call to any of its method into a request to the same method, which can be bound to an event on an element in the web page.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to an ajax call to the doB() method in this class
        $this->response()->jq('#btn-a')->on('click', $this->rq()->doB());

        // Bind the click on the button with id "btn-b" to an ajax call to the doB() method in class ClassB
        $this->response()->jq('#btn-b')->on('click', $this->rq(ClassB::class)->doB());
    }
}
```

The [request factory](../../ui-features/call-factories.html) will often be used in templates to define [event handlers](../../ui-features/templates.html).

#### Component data

The `Jaxon\App\ComponentDataTrait` trait adds a data array to a component.
It provides the methods `set(string $sKey, mixed $xValue): static`, `has(string $sKey): bool`, and `get(string $sKey, mixed $xDefault = null): mixed`, respectively to save, check, or read the data associated with a key in the array.

This array is used to share data between the methods of a component, or to pass data to a component.

```php
$this->cl(UiComponent::class)->set('value', $value)->render();
```

It will therefore be used as an alternative to [stash](../stash.html), for data local to a component.

#### Component extension

The `protected function setupComponent(): void` method allows the application to customize the component setup.
It is called once, right after the component is created.

The `public function extend(string $target, Closure $extension)` allows the application to customize some component properties.
The `$target` parameter can take `item` or `html` as values, depending on the atribute to be customized.
The provided closure will take the initial attribute value as parameter, and must return the new value.

The `extend()` method will often be called in the `setupComponent()` method.

In the pagination components, the `item` attribute extension will automatically be also applied to the pagination links component.

#### Component duplication

The same component can be displayed multiple times on the same page.
Each instance of the component must then be given a different identifier, which will then be used to distinguish them.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class), 'first') ?>>
</div>

<div class="row" <?= attr()->bind(rq(UiComponent::class), 'second') ?>>
</div>
```

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doB()
    {
        // Render the component with the "second" identifier.
        $this->cl(UiComponent::class)->item('second')->render();
    }
}
```

#### Dialogs and alerts helpers

The `Jaxon\App\Dialog\DialogTrait` trait provides the `alert()` and `dialog()` methods, which display [dialogs and messages](../../ui-features/dialogs.html) in the page.

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
