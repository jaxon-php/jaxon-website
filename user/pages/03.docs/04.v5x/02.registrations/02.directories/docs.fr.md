---
title: Enregistrer des répertoires
menu: Répertoires
template: jaxon
---

Bien que cela ne soit pas recommandé, il est possible de déclarer des classes dans des répertoires sans namespaces.
Si on prend un répertoire `/the/class/dir` qui contient les classes suivantes.

Dans le fichier `/the/class/dir/App/FirstClass.php`

```php
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
class SecondClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

#### Déclarer les namespaces

Ces classes sont enregistrées avec Jaxon ainsi.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                // 'autoload' => true,
                // 'protected' => [],
            ]
        ]
    ]
```

Les répertoires peuvent aussi être enregistrés avec des appels aux fonctions de la librairie.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir');
```

En l'absence de namespace, le nom de la classe javascript sera celui de la classe PHP.
Dans l'exemple ci-dessus, les noms des classes javascript seront `FirstClass` et `SecondClass`.

Voici le code javascript généré.

```js
FirstClass = {};
FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
SecondClass = {};
SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
```

#### Définir les options

Des options supplémentaires peuvent être passées aux classes lors de leur enregistrement, et ajoutées aux appels en javascript.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                // 'autoload' => true,
                // 'protected' => [],
                'classes' => [
                    'FirstClass' => [
                        'functions' => [
                            '*' => [
                                'mode' => "'asynchronous'"
                            ]
                        ]
                    ],
                    'SecondClass' => [
                        'functions' => [
                            '*' => [
                                'mode' => "'synchronous'"
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
```

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'classes' => [
        'FirstClass' => [
            'functions' => [
                '*' => [
                    'mode' => "'asynchronous'"
                ]
            ]
        ],
        'SecondClass' => [
            'functions' => [
                '*' => [
                    'mode' => "'synchronous'"
                ]
            ]
        ]
    ]
]);
```

Voici le code javascript généré.

```js
FirstClass = {};
FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'asynchronous' }
    );
};
SecondClass = {};
SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'synchronous' }
    );
};
```

#### Autoloading d'un répertoire

Lors de l'enregistrement d'un répertoire sans namespace, l'option `autoload` permet d'activer l'autoloading.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['autoload' => true]);
```
