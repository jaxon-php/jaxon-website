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
<button type="button" <?= attr()
    ->click(rq(FuncComponent::class)->doThat()) ?>>Click me</button>
```

Without parameters, the `rq()` function returns a `call factory` to create calls to exported functions.

```php
<button type="button" <?= attr()->click(rq()->hello_world()) ?>>Click me</button>
```

In a [component](../../components/func-components.html) class, the `rq()` method, called without parameters, returns a `call factory` for the current class.
If it receives a class as a parameter, it returns a `call factory` for that class.

```php
class FuncComponent
{
    public function show()
    {
        $html = $this->view()->render('users::path/to/view', [
            'rqComponent' => $this->rq(), 
        ]);
    }

    public function doThat()
    {
        // Do something
    }
}
```

```php
<button type="button" <?= attr()
    ->click($this->rqComponent->doThat()) ?>>Click me</button>
```

The `rq()` function and `rq()` method automatically add the configured prefix for exported classes or functions to the generated Javascript code.

#### Javascript functions

The global `jo()` function creates a `call factory` for a Javascript object, which must already exist in the client-side application.
A call to this factory generates the code to call the same function in Javascript, which can then be used in a template, for example, to define an event handler.

```php
// Call the Javascript Example.Embedded.doSomething() function.
<button type="button" <?= attr()
    ->click(jo('Example.Embedded')->doSomething()) ?>>Click me</button>
```

Called without parameters, the `jo()` function returns a `call factory` to the Javascript `window` object.
It can therefore be used to generate calls to Javascript global functions, or to get access to global variables.

```php
// Call the Javascript alert() function.
<button type="button" <?= attr()
    ->click(jo()->alert('Button clicked!!')) ?>>Click me</button>
```

This `call factory` can receive calls to its properties, which can even be chained.

```php
// Javascript console.log()
<button type="button" <?= attr()
    ->click(jo()->console->log('Button clicked!!')) ?>>Click me</button>
```

In the [Response](../../features/responses.html) object, the `jo()` method adds the call to the list of commands to be executed in the browser.

```php
class FuncComponent
{
    public function doThat()
    {
        $this->response->jo('Example.Embedded')->doSomething();
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
        $this->response->jq('#button-id')
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
        $this->response->jq('#button-id')
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
        $this->response->je('button-id')->addEventListener('click',
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
        $this->response->je('button-id')->addEventListener('click',
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

#### Conditional calls

`Call factories` provide functions to check a condition before the call is executed.

The `when()` function executes the call only if a condition is true.
In the following example, the call is executed if the user has checked the box with the id `accepted`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()->when(je('accepted')->checked)) ?>>Click me</button>
```

The `unless()` function executes the call only if a condition is false.
In the following example, the call is executed if the user has not checked the box with the id `refused`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()->unless(je('refused')->checked)) ?>>Click me</button>
```

The `confirm()` function executes the call only if the user answers yes to the question asked.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()->confirm('Are you sure?')) ?>>Click me</button>
```

Values ​​from the web page content can be included in the question, indicating the positions in curly brackets.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()->confirm('You want some {1}? Really, {2}?',
        je('colorselect')->text, je('username')->innerHtml)) ?>>Click me</button>
```

The order of parameters in the message can be different, which is useful for example for translations.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()->confirm('Hello {2}, do you want some {1}?',
        je('colorselect')->text, je('username')->innerHtml)) ?>>Click me</button>
```
