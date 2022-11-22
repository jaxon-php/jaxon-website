---
title: Exclure des méthodes
menu: Exclure des méthodes
template: jaxon
---

L'annotation `@exclude` permet d'avoir dans une classe Jaxon une méthode publique qui ne sera pas présente dans le code javascript généré.

Elle peut être définie sur les classes et les méthodes publiques, et elle ne peut pas être repétée.

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
