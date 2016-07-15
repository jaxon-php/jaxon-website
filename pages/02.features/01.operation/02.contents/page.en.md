---
title: Editing page contents
menu: Page contents
template: jaxon
---

A Jaxon function returns a `Jaxon\Jaxon\Response` object, which provides functions to perform various kind of operations in the web page. New functions can also be added using plugins.

The complete list of functions of the `Jaxon\Response\Response` class is [documented here](/api/Jaxon/Plugin/Response.html).

#### Page content

The following functions update the webpage content.

```php
// Assign the specified value to the element with id "content"
$response->assign('content', 'innerHTML', $sData);
```

```php
// Append the specified data to the element with id "content"
$response->append('content', 'innerHTML', $sData);
```

```php
// Prepend the specified data to the element with id "content"
$response->prepend('content', 'innerHTML', $sData);
```

#### CSS properties

The following functions set CSS properties on the webpage content.

```php
// Set the specified CSS class to the element with id "content"
$response->assign('content', 'className', 'main_content');
```

```php
// Set the background color on the element with id "content"
$response->assign('content', 'style.background', 'blue');
```

#### Javascript functions

The following function runs a given javascript code in the webpage.

```php
$response->script('var done = true;');
```

The following function prints a message in the webpage.

```php
$response->alert('Done!!');
```

#### Plugins

The Jaxon plugins add new functionalities to the `Jaxon\Jaxon\Response` object.
Once it is installed, a plugin is accessed in the `Jaxon\Jaxon\Response` object using it unique identifier.

For example, the [jaxon-toastr](https://github.com/jaxon-php/jaxon-toastr) plugin adds notifications to an application.
```php
$response->toastr->success("You are now using the Toastr Notification plugin!!");
```
