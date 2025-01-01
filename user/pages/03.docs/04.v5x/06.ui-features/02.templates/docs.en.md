---
title: The template functions
menu: Templates
template: jaxon
---

The Jaxon library provides functions for use in templates, to insert generated Javascript and CSS codes into templates, and to attach [components](../../components/node-components.html) and event handlers to page elements.

Among these functions, those provided by the `Jaxon\attr()` object add Jaxon-specific attributes to these elements, which are processed by the Jaxon javascript library in the browser to setup the corresponding features.

#### Include Jaxon's code in the web page

The `css()`, `js()` and `script()` functions of the `Jaxon\jaxon()` object return the codes to include in a web page to make the library work.

```php
<html>
<head>

<?= jaxon()->css() ?>
</head>
<body>


</body>

<?= jaxon()->js() ?>
<?= jaxon()->script() ?>
</html>
```

#### Attacher un composant à un élément

Jaxon provides functions to attach a [component](../../components/node-components.html) to an element of a web page and dynamically manage its content.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
</div>
```

If the same component needs to be displayed multiple times on a page, then a unique identifier must be added to each instance.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class), 'first') ?>>
</div>

<div class="row" <?= attr()->bind(rq(UiComponent::class), 'second') ?>>
</div>
```

The HTML code of a component can be inserted directly into the template.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
    <?= cl(UiComponent::class)->html() ?>
</div>
```

#### Attach an event handler to an element

The Jaxon library provides functions to attach an event handler to one or more elements on a page.

The `on()` function defines an event handler on an element.
It takes as parameters the event name and the function to call, defined using the [call factory](../../call-factory/functions.html).

```php
<select class="form-select" <?= attr()->on('change', rq(FuncComponent::class)->doThat()) ?>>
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>
```

The `attr()->click()` function is a shortcut to define a handler for the `click` event.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)->doThat()) ?>>CLICK ME</button>
```

The usage of the `rq()` function is described in the [Call factories](../call-factories.html) page.

#### Use a selector

It is possible to define an event handler on a set of child elements chosen using a selector, similar to [jQuery](https://jquery.com).

```php
<div <?= attr()->select('.color-choice')->on('change', rq(FuncComponent::class)->doThat()) ?>>
    <select class="form-control color-choice">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

In this case, before the `on()` function is called, there is a call to the `select()` function which takes a [jQuery](https://jquery.com) selector as a parameter.

The [jQuery](https://jquery.com) selector will only apply on the children of the element where the event handler is defined.

#### Multiple definitions

Finally, it is also possible to define multiple event handlers on elements contained in the same parent, by chaining calls to the `select()` and `on()` functions.

```php
<div class="row" <?= attr()
    ->select('.first-choice')->on('change', rq(FuncComponent::class)->doThis())
    ->select('.second-choice')->on('change', rq(FuncComponent::class)->doThat()) ?>>
    <div class="col-md-12">
        <select class="form-control first-choice">
            <option value="black" selected="selected">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>
    </div>

    <div class="col-md-12">
        <select class="form-control second-choice">
            <option value="black" selected="selected">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>
    </div>
</div>
```

Similarily, the [jQuery](https://jquery.com) selectors will only apply on the children of the element where the event handler is defined.
