---
title: The Request Factory
menu: Request Factory
template: jaxon
---

The `Jaxon\Request\Factory` class can be used to create requests to functions or methods exported with Jaxon.

The `rq()` global function returns an instance of this class, which provides the `call()` method to create a request.

The `pr()` global function returns an object which provides a range of other functions to pass elements from the HTML page as parameter to the request.

For example, the following code uses the Request Factory to create a request to a the `setColor()` method of the class `HelloWorld`, passing the value selected in the combobox with id `colorselect` as parameter.

```php
<div class="col-md-4 margin-vert-10">
    <select id="colorselect" name="colorselect"
            onchange="<?php echo rq('HelloWorld')->call('setColor', pr()->select('colorselect')) ?>">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

The Request Factory can also be used to bind a call to a Jaxon function to an event.

```php
public function myFunction()
{
    $response->setEvent('colorselect', 'onchange', rq('HelloWorld')->call('setColor', pr()->select('colorselect')));
    return $response;
}
```

The configured prefix is automatically prepended to the generated javascript call.

The following methods are used to get content from the webpage.

- form($sFormId): returns the values of the form with the given id.
- input($sInputId): returns the value of the input field with the given id.
- checked($sInputId): returns the value of the checkbox with the given id.
- select($sInputId): returns the value of the combobox with the given id.
- html($sElementId): returns the text of the HTML element with the given id.
- js($sValue): returns a javascript variable or function call.

The full list of functions of the `Jaxon\Request\Factory` class is [documented here](/api/Jaxon/Request/Factory.html).

#### Conditional calls

The Request Factory provides 3 functions to check a condition before sending a Jaxon request.

The function `when()` sends the request only if the given condition is true.
In the following example, the request is sent only if the checkbox with id `accepted` is checked.

```php
public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pr()->select('colorselect'))
        ->when(pr()->checked('accepted'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

The function `unless()` sends the request only if the given condition is not true.
In the following example, the request is sent only if the checkbox with id `refused` is not checked.

```php
public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pr()->select('colorselect'))
        ->unless(pr()->checked('refused'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

The function `confirm()` asks a question and sends the request only if the user answers yes.

```php
public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pr()->select('colorselect'))
        ->confirm('Are you sure?');
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

The content from the webpage can be inserted in the question, by giving their position between braces.

```php
public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pr()->select('colorselect'))
        ->confirm('You want {1}? Really, {2}?', pr()->select('colorselect'), pr()->html('username'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

The order of the parameters in the message can be changed, allowing for example to take message translations into account.

```php
public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pr()->select('colorselect'))
        ->confirm('Hey {2}, you really want {1}?', pr()->select('colorselect'), pr()->html('username'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

By default, the confirmation message is printed using the javascript `confirm()` function.
The [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) plugin allows to ask the confirmation question using third party javascript libraries.
