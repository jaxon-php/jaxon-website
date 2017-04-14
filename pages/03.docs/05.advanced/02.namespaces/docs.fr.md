---
title: Enregistrer des répertoires avec des namespaces
menu: Namespaces
template: jaxon
---

Si un répertoire est associé à un namespace, il est possible de l'indiquer lorsqu'il est enregistré avec Jaxon.
Le nom des classes javascript prendra ce namespace en compte.

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

Les classes PHP seront enregistrées ainsi.

```php
$jaxon = jaxon();
$jaxon->addClassDir('/the/class/dir', 'Ns');
$jaxon->registerClasses();
```

Les noms des classes javascript seront `Ns.App.FirstClass` et `Ns.App.SecondClass`.
Le `classpath` est préfixé du namespace du répertoire enregistré.
