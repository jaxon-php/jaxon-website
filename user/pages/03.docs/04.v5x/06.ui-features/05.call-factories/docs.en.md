---
title: The call factories
menu: Call factories
template: jaxon
---

A `call factory` is a PHP class used to generate Javascript calls that will be executed in the browser.
It will be used to insert Javascript calls into templates or define event handlers in templates and components.

`Call factories` have a fluent syntax. They convert the PHP calls they receive into calls to the Javascript functions with the same name, and the same parameters.

Since these parameters can themselves be defined with `call factories`, this allows, while programming on the server, to pass any value present in the web page as a parameter to Javascript calls.

Different `call factories` exist to generate calls to exported classes and functions, to other Javascript functions, and to jQuery or Javascript type selectors.

#### Exported classes and functions

The global function `rq()` creates a `call factory` for the exported class whose name it received as a parameter.
A call to this factory generates the code for the same call in Javascript, which can then be used in a template, for example, to define an event handler.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)->doThat()) ?>>Click me</button>
```

Without any parameter, the `rq()` function returns a `call factory` to create calls to exported functions.

```php
<button type="button" <?= attr()->click(rq()->hello_world()) ?>>Click me</button>
```

In a [component](../../components/func-components.html) class, the `rq()` method, called without parameters, returns a `call factory` for the current class.
If it receives a class name as a parameter, it returns a `call factory` for that class.

```php
class FuncComponent
{
    public function show()
    {
        $html = $this->view()->render('users::path/to/view', [
            'clickHandler' => $this->rq()->doThat(), 
        ]);
    }

    public function doThat()
    {
        // Do something
    }
}
```

```php
<button type="button" <?= attr()->click($this->clickHandler) ?>>Click me</button>
```

In the [Response](../../features/responses.html) object, the `rq()` method adds the call to the list of commands to be executed in the browser.

```php
class FuncComponent
{
    public function doThis()
    {
        // Make an ajax call to the doThat() method.
        $this->response()->rq(FuncComponent::class)->doThat();
    }

    public function doThat()
    {
        // Do something
    }
}
```

> Note: Called without parameter, the `rq()` method of the `Response` object returns a `call factory` for exported functions, and not for the current class.

The `rq()` function and `rq()` method automatically add the configured prefix for exported classes or functions to the generated Javascript code.

#### Javascript functions

The `jo()` global function creates a `call factory` for a Javascript object, which must already exist in the client-side application.

A call to this factory generates the code to call the same function in Javascript, which can then be used in a template, for example, to define an event handler.

```php
// Call the Javascript Example.Embedded.doSomething() function.
<button type="button" <?= attr()->click(jo('Example.Embedded')->doSomething()) ?>>Click me</button>
```

Called without parameters, the `jo()` function returns a `call factory` to the Javascript `window` object.
It can therefore be used to generate calls to Javascript global functions, or to get access to global variables.

```php
// Call the Javascript alert() function.
<button type="button" <?= attr()->click(jo()->alert('Button clicked!!')) ?>>Click me</button>
```

This `call factory` can receive calls to its properties, which can even be chained.

```php
// Javascript console.log()
<button type="button" <?= attr()->click(jo()->console->log('Button clicked!!')) ?>>Click me</button>
// Same as jo('console')->log('Button clicked!!')
```

In the [Response](../../features/responses.html) object, the `jo()` method adds the call to the list of commands to be executed in the browser.

```php
class FuncComponent
{
    public function doThat()
    {
        $this->response()->jo('Example.Embedded')->doSomething();
    }
}
```

#### The selectors

The global function `jq()` creates a `call factory` for a jQuery selector.
It takes a [jQuery selector](https://api.jquery.com/category/selectors/) as a parameter.

A call to this factory generates the Javascript code to read or assign values ​​to the selected elements, or to define event handlers.
It will often be used with the [Response](../../features/responses.html) object, to add the call to the list of commands to be executed in the browser.

```php
class FuncComponent
{
    public function show()
    {
        $this->response()->jq('#button-id')
            ->click($this->rq()->doThat(jq('#button-id')->attr('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

Called without parameters, this `call factory` returns the jQuery object `$(this)`.
It can be passed as a parameter to an event handler, for example.

```php
class FuncComponent
{
    public function show()
    {
        $this->response()->jq('#button-id')
            ->click($this->rq()->doThat(jq()->attr('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

The global function `je()` creates a `call factory` for a Javascript selector corresponding to the [getElementById()](https://developer.mozilla.org/en-US/docs/Web/API/Document/getElementById) function.
It takes the id of the element to be retrieved as a parameter.

A call to this factory generates the Javascript code to read or assign values ​​to the selected element, or to define event handlers.
It will often be used with the [Response](../../features/responses.html) object, to add the call to the list of commands to be executed in the browser.

```php
class FuncComponent
{
    public function show()
    {
        $this->response()->je('button-id')->addEventListener('click',
            $this->rq()->doThat(je('button-id')->getAttribute('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

Called without parameters, this `call factory` returns the Javascript object `this`.
For example, it can be passed as a parameter to an event handler.

```php
class FuncComponent
{
    public function show()
    {
        $this->response()->je('button-id')->addEventListener('click',
            $this->rq()->doThat(je()->getAttribute('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

#### Helpers

The `call factory` created by the global `je()` function also provides helpers for reading values ​​from a web page or form.

- `je($sElementId)->rd()->form()`: returns the values of the form with the given id.
- `je($sElementId)->rd()->input()`: returns the value of the input field with the given id.
- `je($sElementId)->rd()->checked()`: returns the value of the checkbox with the given id.
- `je($sElementId)->rd()->select()`: returns the value of the combobox with the given id.
- `je($sElementId)->rd()->html()`: returns the text of the HTML element with the given id.
- `je()->rd()->page()`: returns the current page number.

The same helpers are also available as globals functions, in the `Jaxon\` namespace.

- `Jaxon\form($sElementId)`: same as `je($sElementId)->rd()->form()`;
- `Jaxon\input($sElementId)`: same as `je($sElementId)->rd()->input()`;
- `Jaxon\checked($sElementId)`: same as `je($sElementId)->rd()->checked()`;
- `Jaxon\select($sElementId)`: same as `je($sElementId)->rd()->select()`;
- `Jaxon\html($sElementId)`: same as `je($sElementId)->rd()->html()`;
- `Jaxon\page()`: same as `je()->rd()->page()`;

#### Conditional calls

`Call factories` provide functions to check a condition before the call is executed.

The `confirm()` function executes the call only if the user answers yes to the question asked.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->confirm('Are you sure?')) ?>>Click me</button>
```

Questions are displayed with [dialog functions](../dialogs.html), and values ​​from the web page content can be included in the question, with the positions indicated in curly brackets.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->confirm('You want some {1}? Really, {2}?',
        je('colorselect')->text, je('username')->innerHtml)) ?>>Click me</button>
```

The order of parameters in the message can be different, which is useful for example for translations.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->confirm('Hello {2}, do you want some {1}?',
        je('colorselect')->text, je('username')->innerHtml)) ?>>Click me</button>
```

The `when()` function executes the call only if a condition is true.
In the following example, the call is executed if the user has checked the box with the id `accepted`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->when(je('accepted')->checked)) ?>>Click me</button>
```

The `unless()` function executes the call only if a condition is false.
In the following example, the call is executed if the user has not checked the box with the id `refused`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->unless(je('refused')->checked)) ?>>Click me</button>
```

Comparison functions can also be used.
Their names begin with an `if`, and they accept two parameters, each of which can be a constant or a call to a `call factory`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->ifeq(je('accepted')->checked, true)) ?>>Click me</button>
```

The following functions are available.

```php
    public function ifeq($xValue1, $xValue2);
    public function ifteq($xValue1, $xValue2);
    public function ifne($xValue1, $xValue2);
    public function ifnte($xValue1, $xValue2);
    public function ifgt($xValue1, $xValue2);
    public function ifge($xValue1, $xValue2);
    public function iflt($xValue1, $xValue2);
    public function ifle($xValue1, $xValue2);
```

Finally, `else` functions can be used to display a message on the screen when the required condition has not been met.
Similar to confirmation, messages are displayed using [dialog functions](../dialogs.html), and values ​​from the web page content can be included in the message.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->when(je('accepted')->checked))
    ->elseShow('Hi {1}, you need to check the Accept box',
        je('username')->innerHtml)) ?>>Click me</button>
```

The following functions are available.

```php
    public function elseShow(string $sMessage, ...$aArgs);
    public function elseInfo(string $sMessage, ...$aArgs);
    public function elseSuccess(string $sMessage, ...$aArgs);
    public function elseWarning(string $sMessage, ...$aArgs);
    public function elseError(string $sMessage, ...$aArgs);
```
