---
title: Le démarrage
menu: Le démarrage
template: jaxon
---

La librairie Jaxon fournit désormais des fonctions qui lui permettent de démarrer à partir d'un fichier de configuration, qui va définir tout ce dont la librairie a besoin pour fonctionner: les classes, et les vues.


```php
// Configuration
jaxon()->app()->setup('/path/to/config.php');
```

Le fichier de configuration comporte deux sections principales, identifiées avec les mots-clés `app` et `lib`.

La section `lib` contient la [configuration de la librairie](../intro/configuration), et de ses plugins.

La section `app` contient la [configuration des classes](./classes) et [celle des vues](./views).

#### Les classes

La section `app.classes` de la configuration contient un tableau des répertoires dans lesquels se trouvent les classes à exporter.
Chaque entrée du tableau représente un répertoire, défini avec les informations suivantes:

- `directory` : le chemin complet du répertoire.
- `namespace` : le namespace associé au répertoire.
- `autoload` : optionnel, booléen, true par défaut, indique si les classes dans le répertoire doivent être autoloadées.
- `separator` : optionnel, le séparateur dans les noms des classes javascript, peut prendre les valeurs `.` (par défaut) ou `_`.
- `protected` : optionnel, un tableau de méthodes à ne pas exporter dans les classes javascript, vide par défaut.

Ce tableau doit toujours contenir au moins une entrée.
En voici un exemple.

```php
    'app' => [
        'classes' => [
            [
                'directory' => dirname(__DIR__) . '/classes',
                'namespace' => '\\Jaxon\\App',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
            ],
        ],
    ],
```

Les options des classes Jaxon sont définies dans la section `app.options.classes` du fichier de configuration.

```php
    'app' => [
        'options' => [
            'classes' => [
                \Jaxon\App\Test\Bts::class => [
                    '*' => [
                        'mode' => "'asynchronous'",
                    ]
                ]
            ],
        ],
    ],
```

#### Les vues

La section `app.views` de la configuration de Armada contient un tableau des répertoires dans lesquels se trouvent les vues.
Chaque entrée du tableau représente un répertoire, défini avec les informations suivantes:

- `directory` : le chemin complet du répertoire.
- `extension` : l'extension à ajouter aux vues du répertoire.
- `renderer` : l'identifiant du moteur de templates à utiliser pour afficher les vues du répertoire.

Chaque entrée du tableau est indexé par un identifiant unique, qui sera utilisé lors de l'affichage pour indiquer dans quel répertoire se trouve la vue.

La configuration suivante définit un répertoire `/path/to/users/views` qui contient des templates Smarty.

```php
    'app' => [
        'views' => [
            'users' => [
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ]
        ]
    ],
```

Le code suivant affiche le template dans le fichier `/path/to/users/views/path/to/view.tpl` avec le moteur Smarty.

```php
    $html = jaxon()->view()->render('users::path/to/view');
```

Si on définit dans la configuration un namespace par défaut, alors l'identifiant peut être omis dans l'appel.

```php
    'app' => [
        'views' => [
            'users' => [
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ]
        ],
        'options' => [
            'views' => [
                'default' => 'users',
            ]
        ]
    ],
```

```php
    $html = jaxon()->view()->render('path/to/view');
```

#### La vue de pagination

Avec Armada, les liens de pagination peuvent être affichés avec n'importe quel moteur de templates (voir [la documentation des vues](/docs/armada/views.html)).
Pour personnaliser la pagination, il faut créer tous les templates de pagination dans un répertoire, puis l'indiquer dans la configuration des vues.

```php
        'views' => array(
            'pagination' => array(
                'directory' => '/chemin/vers/le/repertoire',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ),
        ),
```

Par exemple, voici le contenu du fichier `/chemin/vers/le/repertoire/wrapper.tpl`, qui est un template Smarty.

```html
{if !empty($prev)}
{$prev}
{/if}
{$links}
{if !empty($next)}
{$next}
{/if}
```
