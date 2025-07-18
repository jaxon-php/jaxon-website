---
title: Les packages
menu: Les packages
template: jaxon
---

Un package est un module logiciel complet qui implémente les fonctions backend et frontend d'une solution.
Contrairement à une application, un package est destiné à être intégré dans une page d'une application PHP existante.

#### Utiliser un package

Pour être utilisé dans une application, un package doit être déclaré dans la section `app.packages` de sa configuration.
Chaque entrée de ce tableau est constitué soit simplement du nom de la classe principale du package, soit d'une clé qui est le nom de la classe, et d'une valeur qui est un tableau d'options à passer au package.

Par exemple, le plugin [Supervisor Dashboard](https://github.com/lagdo/jaxon-supervisor) prend en options la liste des serveurs à superviser.

```php
    'app' => [
        // Other config options
        // ...
        'packages' => [
            Lagdo\Supervisor\Package::class => [
                'servers' => [
                    'first_server' => [
                        'url' => 'http://192.168.1.10',
                        'port' => '9001',
                    ],
                    'second_server' => [
                        'url' => 'http://192.168.1.11',
                        'port' => '9001',
                    ],
                ],
            ],
        ],
    ],
```

#### Créer un package

Pour créer un package, il faut d'abord définir sa classe principale, qui doit étendre la classe `Jaxon\Plugin\AbstractPackage`.

La méthode abstraite `public static function config()` retourne sa configuration.
Les fonctions `public function getJs(): string`, `public function getCss(): string`, `public function getScript(): string`, et `public function getJsCode(): ?JsCode` sont les fonctions usuelles de génération de code.
La méthode `protected function init(): void` peut être redéfinie pour initialiser le package.
La méthode `public function getHtml(): string|Stringable` retourne le code HTML initial du package.

La classe `Jaxon\Plugin\AbstractPackage` définit aussi quelques `fonctions finales` qui peuvent être utilisées pour implémenter les autres.
La méthode `public function getConfig()` retourne la configuration passée au package dans l'application.
La méthode `public function getOption()` lit une valeur dans cette configuration.
La méthode `public function view()` retourne une instance du `view renderer`, pour afficher les vues.

Lorsque le package est ajouté à la configuration d'une application et chargé, son code est ajouté à celui de la librairie.

Pour implémenter ses fonctions, un package peut définir des classes et fonctions à exporter, des templates, et des services.
Optionnellement, un package peut aussi inclure des extensions des autres types.

#### Configurer le package

Ces éléments doivent être déclarés dans un fichier de configuration, dont le contenu est similaire à la section `app` de la configuration de Jaxon.

Les entrées `directories`, `classes` et `functions` vont définir respectivement les [répertoires](../../registrations/namespaces.html), les [classes](../../registrations/classes.html) et les [fonctions](../../registrations/functions.html) à exporter.
Dans la section `views`, seront définis les [templates](../../ui-features/views.html) et les moteurs correspondants.
Dans la section `container`, seront définis les services à ajouter dans le [conteneur de dépendances](../../features/dependency-injection.html).

La méthode `public static function config()` peut soit retourner cette configuration dans un tableau, soit le chemin complet vers un fichier PHP où ils sont définis.
