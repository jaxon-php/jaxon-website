---
title: The Request Factory
menu: Request Factory
template: jaxon
---

The `Jaxon\Request\Factory` class can be used to create requests to functions or methods exported with Jaxon.
It provides the `call()` function to create the request, and a range of other functions to pass content of the HTML page elements as parameter to the request.

For example, the following code uses the Request Factory to create a request to a the `setColor()` method of the class `HelloWorld`, passing the value selected in the combobox with id `colorselect` as parameter.

```php
<div class="col-md-4 margin-vert-10">
    <select id="colorselect" name="colorselect"
            onchange="<?php echo rq()->call('HelloWorld.setColor', rq()->select('colorselect')) ?>">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

The Request Factory can also be used in a Jaxon function to bind a call to a Jaxon function to an event.

```php
public function myFunction()
{
    $response->setEvent('colorselect', 'onchange', rq()->call('HelloWorld.setColor', rq()->select('colorselect')));
    return $response;
}
```

The `rq()` global function returns an instance of the `Jaxon\Request\Factory` class.
The configured prefix is automatically prepended to the generated javascript call.

The following methods are used to get content from the webpage.

- form($sFormId): returns the values of the form with the given id.
- input($sInputId): returns the value of the input field with the given id.
- checked($sInputId): returns the value of the checkbox with the given id.
- select($sInputId): returns the value of the combobox with the given id.
- html($sElementId): returns the text of the HTML element with the given id.
- js($sValue): returns a javascript variable or function call.

The full list of functions of the `Jaxon\Request\Factory` class is [documented here](/api/Jaxon/Request/Factory.html).

#### The Request Factory trait

The `Jaxon\Request\Traits\Factory` trait adds a `call()` function to the Jaxon classes, that simplifies the creation of Jaxon requests to their methods.
It takes as a parameter the name of a method, and automatically prepends the name of the javascript class.

```php
class MyClass
{
    use \Jaxon\Request\Traits\Factory;

    public function myMethod($color)
    {
        $response->onClick('button-ok', $this->call('myMethod', rq()->select('colorselect')));
        return $response;
    }
}
```
