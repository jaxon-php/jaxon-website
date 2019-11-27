---
title: The JQuery PHP API
menu: JQuery PHP
template: jaxon
---

The `Jaxon\Response\Response` object provides functions to set [the content and the style of a webpage](../features).
Each of these functions performs an action on an element identified by its `id` attribute.

These functions have some limitations: they can only apply to a single element in the webpage at once, and they required this element to have an `id` HTML attribute.

#### The new API

The JQuery PHP API mimics the behaviour and the syntax of the [jQuery](https://www.jquery.com) javascript library.
Actually, it automatically generates calls to jQuery functions.

The JQuery PHP API allows the developer to use the same selectors as the jQuery library, and therefore can apply a fonction simultaneously to multiple elements in a webpage, selected based on various criteria.
It is simple to learn for those who already know jQuery. However, it requires the jQuery library to be loaded in the webpage to operate properly.

#### Using the API

The PHP API operates the same way as the javascript library.
A first function selects the set of elements to be modified, and the following calls each perform an action on the selected elements.
All these functions can be chained in one call.

The `Response` class provides a method named `jq()`, which selects the DOM elements to be edited.

```php
$response->jq('#message')->html('Yaba daba doo')->css('color', 'blue');
```

Its first parameter is a selector (see the [jQuery documentation](http://api.jquery.com/jQuery/)).
The second, which is optional, is a context which limits the selection to a subpart of the webpage.

Each following call can change the content or the style of each element in the selection,

```php
$response->jq('#message')->html('Yaba daba doo')->css('color', 'blue');
```

or bind an event to a javascript function on each element in the selection,

```php
$response->jq('#message')->click(rq()->func('alert', 'You clicked on the message'));
```

or write or read the value of an attribute on the first element in the selection.

```php
$response->jq('#message')->value = 'Yaba daba doo';
```

#### The functions parameters

The `jq()` method accepts the same [selectors as jQuery](http://api.jquery.com/category/selectors/).
The parameters of the calls after can be of boolean, integer, string or array types.

It is also possible to pass contents from the web page as parameters of the calls, using the `jq()` global function,

```php
$response->jq('#message')->html(jq('#message2')->html());
```

or the [request factory](/docs/requests/factory).

```php
$response->jq('#message')->html(rq()->html('message2'));
```

A Jaxon function can be used as parameter, when binding to an event.

```php
$response->jq('#button')->click(rq('MyClass')->call('myMethod'));
```

The `jq()` global function can be called without any parameter.
This allows, in the context of the execution of a callback, to get access to the element being processed. It is the equivalent of the javascript `this` variable.

In the following example a click on each HTML element with class `.btn` will call the Jaxon function with a different parameter, given by the `data-name` attribute of its parent.

```php
$request = rq('MyClass')->call('myMethod', jq()->parent()->attr('data-name'));
$response->jq('.btn')->click($request);
```

This syntax can also be used to insert content from the webpage in a confirmation question.

```php
$request = rq('MyClass')->call('myMethod')
    ->confirm('Confirm the name {1}?', jq()->parent()->attr('data-name'));
$response->jq('.btn')->click($request);
```

#### Compatibility with jQuery

The PHP API automatically generates javascript code corresponding to the calls it has received, using the `$()` function for the selectors.
Therefore, there is no restriction on particular versions of the jQuery library, but rather on the functions that can be used.

Generally speaking, the API will only allow the use of jQuery functions that apply on selectors.
This includes:

- The attributes [http://api.jquery.com/category/attributes/](http://api.jquery.com/category/attributes/)
- The DOM [http://api.jquery.com/category/traversing/](http://api.jquery.com/category/traversing/)
- The CSS [http://api.jquery.com/category/css/](http://api.jquery.com/category/css/), excepted the methods of the `jQuery` object.
- The events [http://api.jquery.com/category/events/](http://api.jquery.com/category/events/), but only those related to selectors.
