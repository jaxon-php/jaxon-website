---
title: Dependency Injection
menu: Dependency Injection
template: jaxon
cache_enable: false
---

This example shows how to add dependencies in a Jaxon class constructor.

#### How it works

First define the [services](/examples/codes/di-services.html), optionally with the interfaces they implement.

Add these services as parameters in constructor of Jaxon classes, [like in this example](/examples/codes/di-classes.html).

During the initialization, pass the name of the Jaxon class as parameter, instead of an instance.
Then define the dependency injection bindings.
The Jaxon library will instantiate both Jaxon classes and they dependencies when needed.

```php
// Register class name
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, HelloWorld::class);

// Bind the service interface with its implementation
$jaxon->di()->set(ExampleInterface::class, function($di){
    return new Example();
});

// Process the request, if any.
$jaxon->processRequest();
```

The code to call the exported class from javascript does not change.

```php
<!-- Select -->
<select id="colorselect" onchange="<?php echo rq()->call('HelloWorld.setColor', rq()->select('colorselect')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>
<!-- Buttons -->
<button onclick="<?php echo rq()->call('HelloWorld.sayHello', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('HelloWorld.sayHello', 1) ?>">CLICK ME</button>
```
