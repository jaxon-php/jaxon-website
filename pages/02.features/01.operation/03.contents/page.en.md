---
title: Editing webpage content
menu: Content edition
template: jaxon
---

The `Jaxon\Jaxon\Response` object (see the [API](/api/Jaxon/Plugin/Response.html)) provides functions to perform 3 types of operations in the web page.

- Edit the page content (text)
- Edit the page presentation with CSS
- Run javascript code in the page

##### Edit the page content

```php
//Assign content to the element with id "content".
$response->assign('content', 'innerHTML', $sData);

// Append content to the element with id "content".
$response->append('content', 'innerHTML', $sData);

// Prepend content to the element with id "content".
$response->prepend('content', 'innerHTML', $sData);
```

##### Edit the page presentation

```php
// Set the CSS class of the element with id "content".
$response->assign('content', 'className', 'main_content');

// Set the background color of the element with id "content".
$response->assign('content', 'style.background', 'blue');
```

##### Run javascript code

```php
// Run javascript code in the webpage.
$response->script('var done = true;');

// Print a message in the webpage.
$response->alert('Done!!');
```

#### The PHP jQuery API

The above page content and page presentation editing functions lack flexibility, because they can be applied to a single element of the webpage at once, identified by its id.

The `Jaxon\Jaxon\Response` object also implements a set of [functions](/docs/responses/jquery) inspired from the [jQuery](https://www.jquery.com) javascript library, allowing to select elements in the webpage based on their id or class, and to act simultaneously on multiple elements.

```php
$response->jquery('div.box')->css('background-color', 'blue')->css('font-size', '20px')->html('Na popo helele!');
```

#### Plugins

The Jaxon plugins add new functionalities to the `Jaxon\Jaxon\Response` object.
Once it is installed, a plugin is accessed in the `Jaxon\Jaxon\Response` object using its unique identifier.

For example, the [jaxon-toastr](https://github.com/jaxon-php/jaxon-toastr) plugin adds notifications to an application.
```php
$response->toastr->success("You are now using the Toastr Notification plugin!!");
```
