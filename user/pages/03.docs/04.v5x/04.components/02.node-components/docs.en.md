---
title: UI components
menu: UI components
template: jaxon
---

UI components are a new addition in Jaxon version 5.

They have the same functions as [functional components](../func-components.html), but in addition they can be attached to a DOM node. They will then be used to manage the content of this node.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
</div>
```

A component can also be attached to a node dynamically.

```php
$this->response->bind('element-id', rq(UiComponent::class));
```

UI components inherit from the `Jaxon\App\NodeComponent` class, which requires them to implement a `public function html(): string|Stringable` function that returns the contents of the attached node.

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

The `render()` method of a UI component is exported as Javascript, and can therefore be bound to UI events in a method,

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        $this->response->jq('#btn-refresh')
            ->on('click', $this->rq(UiComponent::class)->render());
    }
}
```

or in a template.

```php
<button type="button" class="btn btn-primary" <?php
    echo attr()->click(rq(UiComponent::class)->render()) ?>>Clear</button>
```

#### Component duplication

The same component can be displayed multiple times on the same page.
Each instance of the component must then be given a different item identifier, which will then be used to distinguish them.

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

#### The `NodeResponse` object

The `Jaxon\App\NodeComponent` class has a `node()` method that returns a special response, which is bound to the attached node.

The [page content and style edition functions](../../features/responses.html) in this object no longer have the `string $sTarget` parameter, as they will only apply on the attached node.

#### The other functions of UI components

The `clear()` function removes the inner contents of the attached node from the page.

The `visible(bool $visible)` function, depending on the boolean parameter it receives, displays or hides the attached node, without modifying its contents.

The `protected function before()` and `protected function after()` functions are called respectively before and after the component is displayed in the `render()` function.
They are generally used to prepare or complete the display of the component, either by fetching data or by displaying other components.
