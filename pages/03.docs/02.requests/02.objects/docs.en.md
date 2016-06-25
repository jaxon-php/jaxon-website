---
title: Export objects
menu: Export objects
template: jaxon
---

To export an object, the syntax is:
```php
class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::CALLABLE_OBJECT, $myObject);
```

After being exported, all public methods of the object are present in javascript in a class named `JaxonMyClass`.
The prefix `Jaxon` can be changed using the `core.prefix.class` configuration option.

Here is an example of HTML code that calls a method of the PHP class exported with Jaxon.
```html
<input type="button" value="Submit" onclick="JaxonMyClass.myMethod()" />
```
