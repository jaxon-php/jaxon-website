---
title: Features of the Response class
menu: Responses
template: jaxon
---

The Jaxon functions use an instance of the `Jaxon\Response\Response` class to set a list of commands to be executed in the browser.

These commands can perform 3 types of operations in the web page.
- Edit the page content
- Edit the page presentation with CSS
- Run javascript code in the page

Although the `Jaxon\Response\Response` class implements a rich set of features, it can be extended using [plugins](../../extensions/response.html).

#### Editing the page content and style

The content and the style of a webpage can be modified using these functions.

The functions in this group, excepted `bind()`, are also available in the `Jaxon\Response\NodeResponse` class, but without the `string $sTarget` parameter.

```php
// Assign the specified value to the given element's attribute
assign(string $sTarget, string $sAttribute, string $sValue)

// Assign the specified HTML content to the given element
html(string $sTarget, string $sValue)

// Assign the specified value to the given element's CSS attribute
style(string $sTarget, string $sCssAttribute, string $sValue)

// Append the specified data to the given element's attribute
append(string $sTarget, string $sAttribute, string $sValue)

// Prepend the specified data to the given element's attribute
prepend(string $sTarget, string $sAttribute, string $sValue)

// Replace a specified value with another value within the given element's attribute
replace(string $sTarget, string $sAttribute, string $sSearch, string $sValue)

// Clear the specified attribute of the given element
clear(string $sTarget, string $sAttribute)

// Remove an element from the document
remove(string $sTarget)

// Attached a component to the given element
bind(string $sTarget, Jaxon\Script\JxnCall $xCall, string $sItem = '')
```

When modifying the content, the parameter `$sAttribute` takes the value `innerHTML` or `outerHTML`.

```php
$response->assign('message-id', 'innerHTML', 'Jaxon is cool');
```

When modifying the style, the `$sCssAttribute` parameter takes the CSS attribute to be modified as value.

```php
$response->style('message-id', 'color', 'blue');
```

#### Running javascript code

The above functions either directly execute the specified javascript code, or link the code to an event on the webpage.

The functions in this group are also available in the `Jaxon\Response\NodeResponse` class.

```php
// Call the specified javascript function with the given (optional) parameters
call(string $sFunction)

// Execute the specified json expression
exec(JsExpr $xJsExpr)

// Prompts user with [ok] [cancel] style message box
confirm(Closure $fConfirm, string $sQuestion, array $aArgs = [])

// Display an alert message
alert(string $sMessage, array $aArgs = [])

// Display a debug message to the user
debug(string $sMessage)

// Ask the browser to navigate to the specified URL
redirect(string $sURL, int $nDelay = 0)

// Pause execution of the response commands
sleep(int $tenths)
```

The `confirm()` function takes a callback and a question to ask the user as parameters.
The callback takes a `Jaxon\Response\Response` object as parameter, and the commands added to this object will only be executed if the user answers yes to the question.

```php
public function doThis()
{
    $this->response()->confirm(function($response) {
        $response->style('element-id', 'color', 'blue');
    }, 'Set the element color to blue?');
}
```

#### Deprecated functions

Two groups of functions are now deprecated: those who add or delete a content block in a webpage, and those who link Javascript calls to an event on the webpage.

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

```php
// Set an event handler on the specified element
setEvent(string $sTarget, string $sEvent, string $sScript)

// Set a handler for the "onclick" event on the specified element
onClick(string $sTarget, string $sScript)

// Install an event handler on the specified element
addHandler(string $sTarget, string $sEvent, string $sHandler)

// Remove an event handler from the specified element
removeHandler(string $sTarget, string $sEvent, string $sHandler)
```

The [templates](../../ui-features/templates.html) features must be used instead.
