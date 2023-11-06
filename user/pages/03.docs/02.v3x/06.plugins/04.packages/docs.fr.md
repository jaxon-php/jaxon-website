---
title: Les packages
menu: Les packages
template: jaxon
---

Les packages ont été introduits dans la version 3 de Jaxon. Ils fournissent un ensemble complet de fonctions à une application basée sur Jaxon, accessibles à partir d'une page dédiée.

La particularité unique des packages est qu'ils contiennent tous les composants nécessaires à la mise en oeuvre de la fonctionnalité, y compris le frontend et le backend, tout en étant compatibles avec tout framework ou application PHP.

#### Installation

Comme les autres plugins de Jaxon, un package s'installe avec `Composer`.
Ensuite, il faut le déclarer dans la configuration de Jaxon, et son code CSS et javascript est alors automatiquement ajouté à celui de la librairie Jaxon.

#### Configuration

La configuration d'un package se fait dans la section `app` de la [configuration de Jaxon](http://www.jaxon.loc/fr/docs/v3x/advanced/bootstrap.html). La clé est le nom de la classe principale du package, et les paramètres dépendent de la fonction du package.

Voici un exemple de configuration du package [jaxon-supervisor](https://github.com/lagdo/jaxon-supervisor).

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

#### Utilisation

Un package Jaxon fournit une interface utilisateur qui doit être affichée dans une page de l'application. Son code HTML doit donc être inséré dans celui de cette page, et un code javascript peut optionnellement être exécuté lors du chargement de la page.

L'instance de la classe du package est renvoyée par un appel à `jaxon()->package($packageClassName)`. Le code HTML est retourné par la méthode `getHtml()`. Si la méthode `ready()` est appelée, la librairie Jaxon inclut le code javascript du package dans la page. Il est aussi possible d'insérer directement ce code en utilisant la méthode `getReadyScript()`.
