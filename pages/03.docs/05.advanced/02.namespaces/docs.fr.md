---
title: Exporter avec des namespaces
menu: Namespaces
template: jaxon
---

Lorsqu'un répertoire est enregistré avec Jaxon, il est possible de lui associer un namespace.

Si on prend un répertoire `/the/class/dir` associé au namespace `Ns` et qui contient les classes suivantes.

Dans le fichier `/the/class/dir/App/FirstClass.php`
```php
namespace Ns\App;

class FirstClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

Dans le fichier `/the/class/dir/App/SecondClass.php`
```php
namespace Ns\App;

class SecondClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

Les classes PHP seront exportées ainsi.
```php
$jaxon->addClassDir('/the/class/dir', 'Ns');
$jaxon->registerClasses();
```

Les noms des classes javascript seront `Ns.App.FirstClass` et `Ns.App.SecondClass`.
