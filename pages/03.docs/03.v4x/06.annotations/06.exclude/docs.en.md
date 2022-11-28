---
title: Exclude methods
menu: Exclude methods
template: jaxon
---

The `@exclude` annotation allows to prevent a public method from being exported in the generated javascript code.

It can be declared on classes and public methods, and it cannot be repeated.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    // Cette méthode ne pourra pas être appelée en javascript.
    /**
     * @exclude
     */
    public function doSomething()
    {
    }
}
```
