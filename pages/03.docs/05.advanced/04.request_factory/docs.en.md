---
title: The Request Factory
menu: The Request Factory
template: jaxon
---

The `Jaxon\Request\Factory` class can be used to create requests to functions or methods exported with Jaxon.
It implements the `call()` function to create the request, and a range of other functions to pass content of the HTML page elements as parameter to the request.

For example, the following code uses the Request Factory to create a request to a Jaxon class.

```php
<?php
use Jaxon\Request\Factory as jr;

class MyClass
{
    public function myMethod($myString)
    {
        // Function body
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::CALLABLE_OBJECT, $myObject);
?>
<script type='text/javascript'>
    /* <![CDATA[ */
    window.onload = function() {
        /* call the MyClass->myMethod() method on load */
        <?php echo jr::call('MyClass.myMethod', jr::select('colorselect')) ?>;
    }
    /* ]]> */
</script>
```

The following javascript code will be generated. 
```html
<script type='text/javascript'>
    /* <![CDATA[ */
    window.onload = function() {
        // call the MyClass->myMethod() method on load
        MyClass.myMethod(jaxon.$('colorselect').value);
    }
    /* ]]> */
</script>
```

The full list of functions of the `Jaxon\Request\Factory` class is [documented here](/api/Jaxon/Request/Factory.html).

The `Jaxon\Request\FactoryTrait` trait adds a `call()` function to the Jaxon classes, that simplifies the creation of Jaxon requests to their methods.
It takes as a parameter the name of a method, and automatically prepends the name of the javascript class.
```php
<?php
use Jaxon\Request\Factory as jr;

class MyClass
{
    use \Jaxon\Request\FactoryTrait;

    public function myMethod($myString)
    {
        // Jaxon request to this method
        $request = $this->call('myMethod', jr::select('colorselect'));
        $btn = '<button class="button radius" onclick="' . $request . '" >Click Me</button>'
    }
}
```
