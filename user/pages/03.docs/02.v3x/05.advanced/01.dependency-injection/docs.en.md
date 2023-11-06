---
title: Dependency Injection
menu: Dependency Injection
template: jaxon
---

The Jaxon library allows to add classes and interfaces as parameters of Jaxon classes constructors.

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

The dependences are declared during the library configuration.

```php
jaxon()->di()->set(ExampleInterface::class, function($di){
    return new Example();
});
```

They will then be instanciated at the same time as Jaxon classes, when processing requests.
