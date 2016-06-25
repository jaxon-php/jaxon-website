---
title: Exporter avec des namespaces
menu: Namespaces
template: jaxon
---

Lorsqu'un répertoire est enregistré avec Jaxon, il est possible de lui associer un namespace.

Par exemple, si le répertoire `/the/class/dir` est associé au namespace `My\Ns`, il sera enregistré ainsi.
```php
$jaxon->addClassDir('/the/class/dir', 'My\Ns');
$jaxon->registerClasses();
```

En supposant que la classe suivante soit définie dans le fichier `/the/class/dir/My/App/MyClass.php`,
```php
namespace My\Ns\My\App;

class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}
```
Le nom de la classe javascript correspondante sera `My.Ns.My.App.MyClass`.
