---
title: Service pour l'injection de dépendance
menu: Service de DI
template: jaxon
---

Un service qui va être injecté dans des classes Jaxon peut d'abord être défini par une interface.

```php
namespace Service;

interface IExample
{
    public function message($isCaps);
    public function color($name);
}
```

Ensuite, il y aura une classe qui implémente l'interface.

```php
namespace Service;

class Example implements IExample
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

