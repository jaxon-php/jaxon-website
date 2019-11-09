---
title: Features of the Response class
menu: Features
template: jaxon
---

Each Jaxon function returns an instance of the class `Jaxon\Response\Response`, which contains a list of commands to be executed in the browser.
These commands can perform 3 types of operations in the web page.

- Edit the page content
- Edit the page presentation with CSS
- Run javascript code in the page

#### Editing the page content and style

The content and the style of a webpage can be modified using these functions.

```php
// Assign the specified value to the given element's attribute
assign(string $sTarget, string $sAttribute, string $sData)

// Append the specified data to the given element's attribute
append(string $sTarget, string $sAttribute, string $sData)

// Prepend the specified data to the given element's attribute
prepend(string $sTarget, string $sAttribute, string $sData)

// Replace a specified value with another value within the given element's attribute
replace(string $sTarget, string $sAttribute, string $sSearch, string $sData)

// Clear the specified attribute of the given element
clear(string $sTarget, string $sAttribute)
```

When modifying the content, the parameter `$sAttribute` takes the value `innerHTML` or `outerHTML`.
For example, the following code assigns a text to an HTML block with id `message-id`.

```php
$response->assign('message-id', 'innerHTML', 'Jaxon is cool');
```

When modifying the style, the parameter `$sAttribute` takes the value `style.` followed by the CSS attribute to be modified.
For example, the following code sets the text color of the HTML block with id `message-id`.

```php
$response->assign('message-id', 'style.color', 'blue');
```

The above functions add or delete a content block in a webpage.

```php
// Create a new element in the document
create(string $sParent, string $sTag, string $sId)

// Insert a new element before to the specified element
insert(string $sBefore, string $sTag, string $sId)

// Insert a new element after the specified element
insertAfter(string $sAfter, string $sTag, string $sId)

// Remove an element from the document
remove(string $sTarget)
```

#### Running javascript code

The above functions either directly execute the specified javascript code, or link the code to an event on the webpage.

```php
// Display an alert message
alert(string $sMessage)

// Execute the specified javascript code
script(string $sJsCode)

// Call the specified javascript function with the given (optional) parameters
call(string $sFunction)

// Set an event handler on the specified element
setEvent(string $sTarget, string $sEvent, string $sScript)

// Set a handler for the "onclick" event on the specified element
onClick(string $sTarget, string $sScript)

// Install an event handler on the specified element
addHandler(string $sTarget, string $sEvent, string $sHandler)

// Remove an event handler from the specified element
removeHandler(string $sTarget, string $sEvent, string $sHandler)
```

For example, the following code will call a Jaxon function when the user clicks on the button.

```php
$response->onClick('btn-set-color', rq('MyClass')->call('myMethod', pr()->select('colorselect')));
```

Although the `Jaxon\Response\Response` class implements a rich set of features, it can be extended using [plugins](../plugins).
