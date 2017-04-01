---
title: The JQuery PHP API
menu: JQuery PHP
template: jaxon
---

The `Jaxon\Response\Response` object provides functions to set the content and the layout of a webpage.
Each of these functions performs an action on an element identified by its `id` attribute.
For example, the following code sets the text and the color of the element with id `message`.

```php
$response->assign('message', 'innerHTML', 'Yaba daba doo');
$response->assign('message', 'style.font-size', 'blue');
```

These functions have some limitations: they can only apply to a single element in the webpage at once, and they required this element to have an `id` HTML attribute.

#### The new API

The JQuery PHP API mimics the behaviour and the syntax of the [jQuery](https://www.jquery.com) javascript library.
Actually, it automatically generates javascript code that calls jQuery functions.

The JQuery PHP API allows the developer to use the same selectors as the jQuery library, and therefore can apply a fonction simultaneously to multiple elements in a webpage, selected based on various criteria.
It is simple to learn for those who already know jQuery. However, it requires the jQuery library to be loaded in the webpage to operate properly.

In version 1 of Jaxon, it is available [in a separate plugin](https://github.com/jaxon-php/jaxon-jquery), while it is integrated in version 2.

Example with version 2.

```php
$response->jquery('#message')->html('Yaba daba doo')->css('font-size', 'blue');
```

Example with version 1.

```php
$response->jquery->element('#message')->html('Yaba daba doo')->css('font-size', 'blue');
```
