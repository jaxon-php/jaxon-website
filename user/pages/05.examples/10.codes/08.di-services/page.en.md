---
title: Dependency Injection service
menu: DI Service
template: jaxon
---

A service which is to be injected in Jaxon classes can first be defined as an interface.

```php
namespace Service;

interface ExampleInterface
{
    public function message($isCaps);
    public function color($name);
}
```

Then, there will be a class which implements the interface

```php
namespace Service;

class Example implements ExampleInterface
{
    public function message($isCaps)
    {
        return ($isCaps) ? 'HELLO WORLD!!!!' : 'Hello World!!!!';
    }

    public function color($name)
    {
        return $name;
    }
}
```
