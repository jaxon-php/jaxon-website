---
title: 'Installer et configurer Jaxon'
date: '27-05-2020 07:00'
media:
    images:
        - luca-bravo-unsplash.jpg
taxonomy:
    category:
        - blog
    tag:
        - php
        - ajax
        - configuration
---

Depuis ses premières versions, Jaxon a fait le choix constant d'une installation avec [Composer](https://getcomposer.org/).
Par contre, ses options de configuration ont beaucoup évolué, et sont aujourd'hui très différents de ceux de la [librairie Xajax](https://github.com/Xajax/Xajax), à partir de laquelle elle a été créée.

===

Cet article présente la configuration de la librairie Jaxon, à partir de la version `3.2.0`.

Jaxon supporte 2 modes de configuration: le *mode libraririe* et le *mode application*.
Le *mode librairie* est celui qui a été hérité de Xajax. Il correspond au cas où l'utilisateur enregistre manuellement ses fonctions et ses classes dans Jaxon, qui génère ensuite le code correspondant.
Le *mode application* a été ajouté dans la version 2 de Jaxon, et amélioré dans la version 3. Dans ce mode, la configuration est séparée en 2 sections distinctes, une qui contient les options de la librairie, et une autre qui définit les fonctions et les classes à exporter, les vues, ainsi que leurs options.

#### Le mode librairie

C'est le mode hérité de Xajax. Dans ce mode, la configuration de Jaxon contient les options de la librairie, et éventuellement celles des plugins de réponse.

Voici un exemple de fichier de configuration.

```php
return [
    'core' => [
        'language' => 'en',
        'encoding' => 'UTF-8',
        'request' => [
            'uri' => 'ajax.php',
        ],
        'prefix' => [
            'class' => '',
        ],
        'debug' => [
            'on' => false,
            'verbose' => false,
        ],
        'error' => [
            'handle' => false,
        ],
    ],
    'js' => [
        'lib' => [
            'uri' => 'https://cdn.jaxon-php.org/libs/jaxon/1.2.0',
        ],
        'app' => [
            // 'uri' => '',
            // 'dir' => '',
            'export' => false,
            'minify' => false,
        ],
    ],
    'assets' => [
        'include' => [
            'all' => true,
        ],
    ],
    'dialogs' => [
        // 'libraries' => ['pgwjs', 'bootstrap', 'toastr'],
        'default' => [
            'modal' => 'bootbox',
            'message' => 'toastr',
            'question' => 'noty',
        ],
        'toastr' => [
            'options' => [
                'closeButton' => true,
                'closeDuration' => 0,
                'positionClass' => 'toast-top-center'
            ],
        ],
    ],
];
```

Ces options sont décrites [dans la documentation](/docs/v3x/about/configuration.html).
Le bloc `'core'` contient les options générales de Jaxon, le bloc `'js'` définit les options de la partie javascript, et le bloc `'assets'` concerne le traitement des fichiers statiques et librairies tierces (CSS et javascript).

Le bloc `dialogs` définit les options de la librairie [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs).

#### Le mode application

Dans ce mode, la configuration est separée en deux parties.
La première contient les options de la librairie Jaxon, qui sont présentées dans le paragraphe précédent.
La seconde permet de déclarer les fonctions et les classes PHP à exporter, les vues, ainsi que leurs options.
Deux autres types d'options existent, pour définir l'injection de dépendance pour les classes, et pour inclure des packages tiers dans l'application.

La particularité de ce mode est de permettre à Jaxon d'être paramétré entièrement à partir de son fichier de configuration, et donc de pouvoir [démarrer et être utilisé](/docs/v3x/advanced/bootstrap.html) sans avoir besoin de coder les instructions.

Voici un exemple de fichier de configuration.
```php
return [
    'app' => [
        'functions' => ['helloWorld'],
        'classes' => [
            HelloWorld::class => [
                '*' => [
                    'mode' => "'asynchronous'",
                ],
                'sayHello' => [
                    'mode' => "'synchronous'",
                ],
            ]
        ],
        'directories' => [
            dirname(__DIR__) . '/app' => [
                'namespace' => '\\Jaxon\\App',
                // 'separator' => '.',
                // 'protected' => [],
                // 'autoload' => true,
            ],
        ],
        'container' => [
            HelloWorld::class => function($di) {
                $optionFromDI = $di->get('option_key');
                $createdOption = new Option();
                return new HelloWorld($optionFromDI, $createdOption);
            }
        ],
        'views' => [
            'smarty' => [
                'directory' => dirname(__DIR__) . '/views/smarty',
                'extension' => '.tpl',
                'renderer' => 'smarty',
                'register' => true,
            ],
            'blade' => [
                'directory' => dirname(__DIR__) . '/views/blade',
                'extension' => '.blade.php',
                'renderer' => 'blade',
                'register' => true,
            ],
            'twig' => [
                'directory' => dirname(__DIR__) . '/views/twig',
                'extension' => '.html.twig',
                'renderer' => 'twig',
                'register' => true,
            ],
        ],
        'options' => [
            'views' => [
                'default' => 'default',
            ],
        ],
        'packages' => [
            Third\Party\Package::class => [
                // Package specific options
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'language' => 'en',
            'encoding' => 'UTF-8',
            'request' => [
                'uri' => 'ajax.php',
            ],
            'prefix' => [
                'class' => '',
            ],
            'debug' => [
                'on' => false,
                'verbose' => false,
            ],
            'error' => [
                'handle' => false,
            ],
        ],
        'js' => [
            'lib' => [
                'uri' => 'https://cdn.jaxon-php.org/libs/jaxon/1.2.0',
            ],
            'app' => [
                // 'uri' => '',
                // 'dir' => '',
                'export' => false,
                'minify' => false,
            ],
        ],
        'assets' => [
            'include' => [
                'all' => true,
            ],
        ],
        'dialogs' => [
            // 'libraries' => ['pgwjs', 'bootstrap', 'toastr'],
            'default' => [
                'modal' => 'bootbox',
                'message' => 'toastr',
                'question' => 'noty',
            ],
            'toastr' => [
                'options' => [
                    'closeButton' => true,
                    'closeDuration' => 0,
                    'positionClass' => 'toast-top-center'
                ],
            ],
        ],
    ],
];
```

Les options de la librairie sont définies sous la clé `lib`. Ils ont déjà été présentés dans la section précédente.

Les options de l'application sont définies sous la clé `app`.

Les blocs `functions`, `classes` et `directories` permettent respectivement d'enregistrer des [fonctions](/docs/v3x/registrations/functions.html), des [classes individuelles](/docs/v3x/registrations/classes.html), ou encore des [répertoires de classes](/docs/v3x/registrations/directories.html) dans la librairie. Les répertoires peuvent être associés à des [namespaces](/docs/v3x/registrations/namespaces.html).

Le bloc `container` permet de définir [l'injection de dépendance](/docs/v3x/advanced/dependency-injection.html) pour les classes exportées. Cette fonctonnalité est très importante dans la version 3 de Jaxon, où les classes exportées ne peuvent plus être instanciées par le développeur. C'est alors le seul moyen pour que ces classes puissent prendre des paramètres dans leurs constructeurs.

Le bloc `views` permet de déclarer [les vues](/docs/v3x/advanced/views.html) dans l'application. Des moteurs de templates différents peuvent être utilisés, mais toujours avec la même api. Si Jaxon est utilisé avec un framework PHP, l'api donne également accès aux vues qui y sont définies.

Le bloc `options` définit les options spécifiques aux vues.

Enfin, le bloc `packages` permet d'inclure des [packages](/docs/v3x/plugins/packages.html) tiers dans l'application.
La configuration d'un package peut elle-même avoir des blocs `functions`, `classes`, `directories`, `container` et `views`, dont les données seront combinées à celles de l'application.
C'est cela qui permet à un package d'enrichir une application avec un ensemble complet de fonctions sur le backend et le frontend.

#### En conclusion

Le *mode application* est celui qui est conseillé lors de l'utilisation de la librairie Jaxon dans sa version 3.
Il est plus simple car la quantité de code à écrire pour que la librairie démarre et fonctionne est réduite au minimum.
