---
title: The Parameter Factory
menu: Parameter Factory
template: jaxon
published: true
---

In addition to the `Request Factory`, Jaxon also provides a `Parameter Factory`, which can be used to define the parameters to pass to Ajax calls to exported functions and methods.
It will be useful when the parameter value comes from the web page, that is to say either from HTML (for example a form) or from javascript.

#### The `Parameter Factory` class

The `Parameter Factory` is implemented by the `Jaxon\Request\Factory\ParameterFactory` class.
The `Jaxon\pm()` global function returns an instance of this class, which provides a range of other functions to pass elements from the HTML page as parameter to an Ajax request.

The following methods are used to get content from the webpage.

- `pm()->form($sFormId)`: returns the values of the form with the given id.
- `pm()->input($sInputId)`: returns the value of the input field with the given id.
- `pm()->checked($sInputId)`: returns the value of the checkbox with the given id.
- `pm()->select($sInputId)`: returns the value of the combobox with the given id.
- `pm()->html($sElementId)`: returns the text of the HTML element with the given id.
- `pm()->js($sValue)`: returns a javascript variable or function call.

Given the following HTML code,

```html
<div class="col-md-4 margin-vert-10">
    <select id="colorselect" name="colorselect">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

The following PHP code will bind a call to a Jaxon function to the `onchange` event on the HTML select component.

```php
use function Jaxon\pm;
use function Jaxon\rq;

public function myFunction()
{
    $response->setEvent('colorselect', 'onchange', rq('HelloWorld')->call('setColor', pm()->select('colorselect')));
    return $response;
}
```
