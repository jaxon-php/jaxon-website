---
title: Les hooks
menu: Les hooks
template: jaxon
---

En plus de [callbacks globales](../../requests/php-callbacks.html), Jaxon permet de définir des callbacks dans les classes.
Pour les différencier, ces dernières sont appelées des `hooks`.

Un `hook` est une méthode publique ou protégée d'une classe Jaxon, qui est configurée pour être automatiquement appelée avant ou après le traitement d'une requête Jaxon vers une méthode de cette classe.

La configuration des hooks se fait avec des annotations dans les classes, ou à l'enregistrement dans le [fichier de configuration](../../about/configuration.html), ou [avec des appels à la classe Jaxon](../../registrations/namespaces.html).

### Annotations

Les annotations `@before` et `@after` permettent de configurer les hooks dans les classes Jaxon.
Elles prennent en paramètre le nom de méthode à appeler.

Si l'annotation est définie sur une classe Jaxon, le hook sera appelé pour les requêtes vers toutes ses méthodes.

```php
namespace Ns\App;

use Jaxon\App\FuncComponent;

/**
 * @before beforeHook
 */
class FirstClass extends FuncComponent
{
    protected function beforeHook()
    {
    }

    public function doThat()
    {
    }
}
```

Si l'annotation est définie sur une méthode, le hook sera appelé uniquement pour les requêtes vers cette méthode.

```php
namespace Ns\App;

use Jaxon\App\FuncComponent;

class SecondClass extends FuncComponent
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
    }
}
```

Il est possible de passer des paramètres constants (entiers, booléens ou caractères) à des hooks.
Ils doivent être ajoutés entre crochets `[]` après le nom de la méthode.

```php
class FirstClass extends FuncComponent
{
    protected function beforeHook()
    {
    }

    /**
     * @before beforeHook [true, 1]
     */
    public function doThis()
    {
    }

    /**
     * @before beforeHook ["string"]
     */
    public function doThat()
    {
    }
}
```

### Configuration

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

```php
jaxon()->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
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

Il est possible de passer des paramètres constants (entiers, booléens ou caractères) à des hooks.
Il faut alors utiliser le nom de la méthode comme index et les paramètres comme valeurs dans le tableau.

```php
    'doThat' => [
        '__after' => [
            'afterHook1' => ['p1'],
            'afterHook2' => ['p1', 'p2'],
        ],
    ],
```

#### Accès à la méthode appelée

Si la classe Jaxon hérite d'une des classes de composants, le nom et les paramètres de la fonction appelée par la requête sont obtenus avec des appels à `$this->target()->method()` et `$this->target()->args()`.

La méthode `$this->target()` ne renvoie une valeur non nulle que lorsqu'elle est appelée dans la classe qui est la cible de la requête Ajax.
Elle peut servir à exécuter des actions différentes selon la méthode appelée.
