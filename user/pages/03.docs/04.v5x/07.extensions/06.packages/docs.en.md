---
title: Packages
menu: Packages
template: jaxon
---

A package is a complete software module that implements the backend and frontend functions of a solution.
Unlike an application, a Jaxon package is intended to be integrated into a page of an existing PHP application.

### Use a package

To be used in an application, a package must be declared in the `app.packages` section of its configuration.
Each entry in this array consists of either the name of the package's main class, or the name of the class as the key, and an array of options to pass to the package as the value.

For example, the [Supervisor Dashboard](https://github.com/lagdo/jaxon-supervisor) plugin takes as options the list of servers to monitor.

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

### Create a package

To create a package, its main class must first be defined, and must extend the `Jaxon\Plugin\AbstractPackage` class.
If it generates code, it can also implement the `Jaxon\Plugin\CodeGeneratorInterface` or `Jaxon\Plugin\CodeGeneratorInterface` interface.

The abstract method `public static function config()` returns its configuration.
The `protected function init(): void` method can be overridden to initialize the package.
The `public function getHtml(): string|Stringable` method returns the initial HTML code of the package.

The `Jaxon\Plugin\AbstractPackage` class also defines some `final functions` that can be used to implement the others.
The `public function getConfig()` method returns the configuration passed to the package in the application.
The `public function getOption()` method reads a value from that configuration.
The `public function view()` method returns an instance of the `view renderer`, for displaying views.

When a package is added to an application's configuration and loaded, its code is added to the library's code.

To implement its features, a package can define classes and functions to export, templates, and services.
Optionally, a package can also include extensions of any other types.

### Configure the package

These elements must be declared in a configuration file, the contents of which are similar to the `app` section of the Jaxon configuration.

The `directories`, `classes`, and `functions` entries will define the [directories](../../registrations/namespaces.html), [classes](../../registrations/classes.html), and [functions](../../registrations/functions.html) to export, respectively.
The `views` section will define the [templates](../../ui-features/views.html) and corresponding engines.
The `container` section will define the services to be added to the [dependency container](../../features/dependency-injection.html).

The `public static function config()` function in the package class can either return this configuration in an array, or the full path to a PHP file where they are defined.

### The configuration `provider`

In some cases, it can be useful to dynamically define the configuration options for a package.
The `provider` option can be used to define a closure that will return the desired values.

```php
use Jaxon\Di\Container;

    'app' => [
        // Other config options
        // ...
        'packages' => [
            Lagdo\Supervisor\Package::class => [
                'provider' => function(array $options, Container $di) {
                    return [
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
                    ];
                },
            ],
        ],
    ],
```

The closure receives as parameters the options defined for the package in addition to the `provider` option, as well as an instance of the dependency container, which it can use to determine the final configuration of the package.
