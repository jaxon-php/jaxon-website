---
title: Enregistrer des répertoires avec des namespaces
menu: Namespaces
template: jaxon
---

La façon la plus simple d'enregistrer des classes avec Jaxon est de fournir un répertoire et un namespace.
Toutes les classes dans le répertoires sont enregistrées, et les classes javascript correspondantes sont nommées en fonction du nom complet des classes PHP.

Soit un répertoire `/the/class/dir` associé au namespace `Ns` et qui contient les classes suivantes.

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

#### Déclarer les namespaces

La section `app.directories` de la configuration contient un tableau des répertoires dans lesquels se trouvent les classes à exporter.
Chaque entrée du tableau représente un répertoire, défini avec son chemin complet et les informations suivantes:

- `path`: mandatory, le chemin du répertoire.
- `namespace` : le namespace associé au répertoire.
- `autoload` : optionnel, booléen, true par défaut, indique si le répertoire doit être ajouté à l'autoloader.
- `separator` : optionnel, le séparateur dans les noms des classes javascript, peut prendre les valeurs `.` (par défaut) ou `_`.
- `protected` : optionnel, un tableau de méthodes à ne pas exporter dans les classes javascript, vide par défaut.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
            ]
        ]
    ]
```

Les namespaces peuvent aussi être enregistrés avec des appels aux fonctions de la librairie.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['namespace' => 'Ns']);
```

Les noms des objets javascript seront `Ns.App.FirstClass` et `Ns.App.SecondClass`, avec les méthodes `Ns.App.FirstClass.myMethod()` et `Ns.App.SecondClass.myMethod()`, qui vont envoyer des requêtes Ajax vers les méthodes PHP correspondantes.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments }
    );
};
```

#### Ajouter des options aux classes

Des options supplémentaires peuvent être passées aux classes lors de leur enregistrement, et ajoutées aux appels en javascript.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'functions' => [
                            '*' => [
                                'mode' => "'asynchronous'",
                            ]
                        ]
                    ],
                    \Ns\App\SecondClass::class => [
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
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\FirstClass::class => [
            'functions' => [
                '*' => [
                    'mode' => "'asynchronous'"
                ]
            ]
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                '*' => [
                    'mode' => "'synchronous'"
                ]
            ]
        ]
    ]
]);
```

Les entrées sont indexées par le nom des classes javascript, qui dans ce cas est le nom complet de la classe PHP correspondante, avec son namespace.

Voici le code javascript généré.

```js
Ns = {};
Ns.App = {};
Ns.App.FirstClass = {};
Ns.App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.FirstClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'asynchronous' }
    );
};
Ns.App.SecondClass = {};
Ns.App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.SecondClass', jxnmthd: 'myMethod' }, { parameters: arguments, mode: 'synchronous' }
    );
};
```

#### Autoloading d'un namespace

Lors de l'enregistrement d'un répertoire avec namespace, l'option `autoload` permet d'activer l'autoloading.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['namespace' => 'Ns', 'autoload' => true]);
```
