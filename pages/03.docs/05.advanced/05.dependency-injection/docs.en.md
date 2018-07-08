---
title: Dependency Injection
menu: Dependency Injection
template: jaxon
---

Starting from version `2.1.6`, the Jaxon library allows to add classes and interfaces as parameters of Jaxon classes constructors.

```php
class HelloWorld
{
    protected $service;

    public function __construct(ExampleInterface $service)
    {
        $this->service = $service;
    }
}
```

The dependences are declared while configuring the library.

```php
jaxon()->di()->set(ExampleInterface::class, function($di){
    return new Example();
});
```

These classes will then be instanciated at the same time as Jaxon classes, when processing Ajax requests.
