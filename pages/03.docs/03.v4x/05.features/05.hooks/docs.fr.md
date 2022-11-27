---
title: Les hookks
menu: Les hooks
template: jaxon
---

Un hook est une méthode publique ou protégée d'une classe Jaxon, qui est configurée pour être automatiquement appelée avant (hook `__before`) ou après (hook `__after`) le traitement d'une requête Jaxon vers une méthode de cette classe.

### Configuration

La configuration des hooks se fait à l'enregistrement [d'une classe](../../02.registrations/02.classes/) ou [d'un répertoire](../../02.registrations/03.directories/), ou dans le [fichier de configuration](../01.bootstrap/).

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\FirstClass::class => [
            'functions' => [
                '*' => [
                    '__before' => 'beforeHook'
                ]
            ]
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                'doThat' => [
                    '__after' => ['firstAfterHook', 'secondAfterHook']
                ]
            ]
        ]
    ]
]);
```

```php
    'app' => [
        'directories' => [
            '/the/class/dir' => [
                'namespace' => 'Ns',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'functions' => [
                            '*' => [
                                '__before' => 'beforeHook'
                            ]
                        ]
                    ],
                    \Ns\App\SecondClass::class => [
                        'functions' => [
                            'doThat' => [
                                '__after' => ['firstAfterHook', 'secondAfterHook']
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
```

Dans la classe `\Ns\App\FirstClass`, la méthode `beforeHook()` sera appelée avant le traitement des requêtes vers toutes les méthodes.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class FirstClass extends CallableClass
{
    protected function beforeHook()
    {
    }

    public function doThat()
    {
        return $this->response;
    }
}
```

Dans la classe `\Ns\App\SecondClass`, les méthodes `firstAfterHook` et `secondAfterHook` seront appelées lors du traitement des requêtes vers la méthode `doThat()`.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
{
    protected function firstAfterHook()
    {
    }

    protected function secondAfterHook()
    {
    }

    public function doThat()
    {
        return $this->response;
    }
}
```

### Paramètres des hooks

Des paramètres (constantes ou tableaux de constantes) peuvent être passés aux hooks lors de leur définition.

```php
    'doThat' => [
        '__after' => [
            'afterHook1' => ['p1'],
            'afterHook2' => ['p1', 'p2'],
        ],
    ],
```

Le nom et les paramètres de la fonction appelée par la requête peuvent être passés en paramètre, en utilisant les valeurs `__method__` et `__args__`.

```php
    'param' => [
        '__before' => [
            'beforeHook' => ['__method__', '__args__']
        ],
    ],
```

### Annotation

[Les annotations `@before` et `@after`](../../06.annotations/06.hooks/) permettent de configurer les hooks dans les classes Jaxon.

Si l'annotation est définie sur une classe Jaxon, le hook sera appelé pour les requêtes vers toutes ses méthodes.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

/**
 * @before beforeHook
 */
class FirstClass extends CallableClass
{
    protected function beforeHook()
    {
    }

    public function doThat()
    {
        return $this->response;
    }
}
```

Si l'annotation est définie sur des méthodes, le hook sera appelé uniquement pour les requêtes vers celles-ci.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
{
    protected function firstAfterHook()
    {
    }

    protected function secondAfterHook()
    {
    }

    /**
     * @after firstAfterHook
     * @after secondAfterHook
     */
    public function doThat()
    {
        return $this->response;
    }
}
```
