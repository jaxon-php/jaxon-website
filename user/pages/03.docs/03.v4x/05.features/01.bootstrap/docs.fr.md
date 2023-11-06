---
title: Le bootstrapping
menu: Le bootstrapping
template: jaxon
---

La librairie Jaxon peut démarrer à partir d'un fichier de configuration, qui définit tout ce dont elle a besoin pour fonctionner: les fonctions, les classes, les vues, et toutes les autres options.


```php
// Configuration
jaxon()->app()->setup('/path/to/config.php');
```

Le fichier de configuration comporte deux sections principales, identifiées avec les mots-clés `app` et `lib`.

La section `lib` contient la configuration de la librairie, et de ses plugins.

La section `app` contient la configuration des fonctions de niveau applicatif telles que l'export des classes et fonctions, ou les vues.

#### Les fonctions

La section `app.functions` de la configuration contient un tableau de fonctions à exporter.

En voici un exemple.

```php
    'app' => [
        'functions' => [
            'hello_world',
            'sayhello',
        ],
    ],
```

Des options peuvent être ajoutées aux fonctions.

```php
    'app' => [
        'functions' => [
            'hello_world' => [
                'mode' => "'asynchronous'",
            ],
        ],
    ],
```

#### Les classes

La section `app.classes` de la configuration contient un tableau de classes à exporter.

En voici un exemple.

```php
    'app' => [
        'classes' => [
            'HelloWorld',
            'OtherClass',
        ],
    ],
```

Des options peuvent être ajoutées aux méthodes des classes.

```php
    'app' => [
        'classes' => [
            'HelloWorld' => [
                'functions' => [
                    'setColor' => [
                        'mode' => "'synchronous'"
                    ],
                    '*' => [
                        'mode' => "'asynchronous'"
                    ],
                ],
            ],
        ],
    ],
```

#### Les répertoires

La section `app.directories` de la configuration contient un tableau des répertoires dans lesquels se trouvent les classes à exporter.
Chaque entrée du tableau représente un répertoire, défini avec son chemin complet et les informations suivantes:

- `namespace` : le namespace associé au répertoire.
- `autoload` : optionnel, booléen, true par défaut, indique si les classes dans le répertoire doivent être autoloadées.
- `separator` : optionnel, le séparateur dans les noms des classes javascript, peut prendre les valeurs `.` (par défaut) ou `_`.
- `protected` : optionnel, un tableau de méthodes à ne pas exporter dans les classes javascript, vide par défaut.

En voici un exemple.

```php
    'app' => [
        'directories' => [
            dirname(__DIR__) . '/classes' => [
                'namespace' => '\\Jaxon\\App',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
            ]
        ]
    ]
```

Des options peuvent être ajoutées aux méthodes des classes.

```php
    'app' => [
        'directories' => [
            dirname(__DIR__) . '/classes' => [
                'namespace' => '\\Jaxon\\App',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
                'classes' => [
                    \Jaxon\App\Test\Bts::class => [
                        'functions' => [
                            '*' => [
                                'mode' => "'asynchronous'",
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
```
