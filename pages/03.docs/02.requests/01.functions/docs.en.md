---
title: Export functions
menu: Export functions
template: docs
---

To export a function, the syntax is:
```php
function my_function()
{
    // Function body
}

$jaxon->register(Jaxon::USER_FUNCTION, "my_function");
```
After being exported, this function can be called in javascript with the name `jaxon_my_function()`. The prefix `jaxon_` can be changed using the `core.prefix.function` configuration option.

Here is an example of HTML code that calls the PHP function exported with Jaxon.
```html
<input type="button" value="Submit" onclick="jaxon_my_function()" />
```

A method of a class can also be exported as a function. For this, the second parameter of the function `register()` must be an array, as in the following example.
```php
class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::USER_FUNCTION, array("my_function", $myObject, "myMethod"));
```

If the array contains two elements, the exported javascript function will have the same name as the method.
