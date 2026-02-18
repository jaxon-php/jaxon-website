---
title: Définir des options
menu: Les options
template: jaxon
---

Jaxon permet de définir des options lors de la déclaration des namespaces, classes et fonctions.

Ces options peuvent s'appliquer au code PHP, au code Javascript, ou aux deux.

### Les options PHP

Lorsqu'elle s'applique au code PHP, les options sont ajoutées aux métadonnées des classes et fonctions.
Elles seront prises en compte lors de leur traitement.

C'est le cas par exemple des options pour [les callbacks de classes](../../requests/php-callbacks.html), ou pour [l'upload](../../features/upload.html).

### Les options Javascript

Lorsqu'elle s'applique au code Javascript, les options sont ajoutées aux paramètres des requêtes Ajax vers les classes et fonctions.

C'est le cas par exemple des options pour [les callbacks Javascript](../../requests/js-callbacks.html), ou pour [l'upload](../../features/upload.html).

### L'option `excluded`

L'option `excluded` est différente, car elle va plutôt indiquer qu'une classe ou une méthode publique PHP ne doit pas être exportée vers Javascript.

Dans le fichier de configuration.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'excluded' => true,
                    ],
                    \Ns\App\SecondClass::class => [
                        'functions' => [
                            'doThat' => [
                                'excluded' => true,
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
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\FirstClass::class => [
            'excluded' => true,
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                'doThat' => [
                    'excluded' => true,
                ]
            ]
        ]
    ]
]);
```

Avec des attributs.

```php
use Jaxon\Attributes\Attribute\Exclude;

// Cette classe ne sera pas exportée en javascript.
#[Exclude]
class FirstClass
{
}
```

```php
use Jaxon\Attributes\Attribute\Exclude;

class SecondClass
{
    #[Exclude]
    public function doThat()
    {
        // Cette méthode ne sera pas exportée en javascript.
    }
}
```

```php
use Jaxon\Attributes\Attribute\Exclude;

class SecondClass
{
    #[Exclude(true)]
    public function doThat()
    {
        // Cette méthode ne sera pas exportée en javascript.
    }

    #[Exclude(false)]
    public function doThis()
    {
        // Cette méthode sera exportée en javascript.
    }
}
```

Avec des annotations.

```php
// Cette classe ne sera pas exportée en javascript.
/**
 * @exclude
 */
class FirstClass
{
}
```

```php
class SecondClass
{
    /**
     * @exclude
     */
    public function doThat()
    {
        // Cette méthode ne sera pas exportée en javascript.
    }
}
```

```php
class SecondClass
{
    /**
     * @exclude true
     */
    public function doThat()
    {
        // Cette méthode ne sera pas exportée en javascript.
    }

    /**
     * @exclude false
     */
    public function doThis()
    {
        // Cette méthode sera exportée en javascript.
    }
}
```

### L'option `export`

L'option `export` définit dans un composant Jaxon un peu plus finement les méthodes qui doivent être exportées en Javascript.

Trois valeurs, toutes des tableaux noms de fonctions, peuvent être définies dans cette option.
- base: les méthodes des classes de base des composants à exporter: `render`, `clear` et `visible`.
- only: les méthodes des classes des composants de l'application à exporter.
- except: les méthodes des classes des composants de l'application à ne pas exporter.

Dans le fichier de configuration.

```php
    'app' => [
        'directories' => [
            [
                'path' => '/the/class/dir',
                'namespace' => '\\Ns',
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'export' => [
                            'base' => ['render'],
                            'only' => [],
                            'except' => [],
                        ],
                    ],
                ]
            ]
        ]
    ]
```

Avec des attributs.

```php
use Jaxon\Attributes\Attribute\Export;
use Ns\App\FirstClass;

// La méthode render() sera exportée en javascript.
#[Export(base: ['render'])]
class FirstClass extends \Jaxon\App\NodeComponent
{
}
```

Avec des annotations.

```php
use Ns\App\FirstClass;

// La méthode render() sera exportée en javascript.
/**
 * @export ["base": ["render"]]
 */
class FirstClass extends \Jaxon\App\NodeComponent
{
}
```
