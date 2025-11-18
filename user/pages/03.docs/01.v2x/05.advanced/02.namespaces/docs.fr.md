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

Voici le code javascript généré par Jaxon.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
```

#### Définir les options des requêtes Jaxon

Des options supplémentaires peuvent être passées aux classes lors de leur enregistrement, et ajoutées aux appels en javascript.
Pour cela, il faut passer à l'appel à `$jaxon->registerClasses()` un tableau dont chaque entrée définit les options d'une classe.

Les entrées sont indexées par le nom des classes javascript, qui dans ce cas est le nom complet de la classe PHP correspondante, avec son namespace.

```php
$jaxon->registerClasses([
    \Ns\App\FirstClass::class => [
        '*' => [
            'mode' => "'asynchronous'"
        ]
    ],
    \Ns\App\SecondClass::class => [
        '*' => [
            'mode' => "'synchronous'"
        ]
    ]
]);
```

Voici le code javascript généré par Jaxon.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'asynchronous' }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'synchronous' }
    );
};
```
