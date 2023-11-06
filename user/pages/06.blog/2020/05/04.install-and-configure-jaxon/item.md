---
title: 'Install and configure Jaxon'
date: '28-05-2020 08:00'
media:
    images:
        - emile-perron-unsplash.jpg
taxonomy:
    category:
        - blog
    tag:
        - php
        - ajax
        - configuration
---

Since its very first releases, Jaxon has made the choice to be installed with [Composer](https://getcomposer.org/).
However, there have been a lot of changes on its configuration options, which today are very different from those of the [Xajax library](http://www.xajax-project.org), from which it was originally forked.

===

This article explains the Jaxon library configuration, starting from version `3.2.0`.

Jaxon supports 2 configuration modes: the *library mode* and the *application mode*.
The *library mode* is the one that was inherited from Xajax. It corresponds to the case where the user manually registers his functions and classes in Jaxon, which then generates the corresponding code.
The *application mode* was added in version 2 of Jaxon, and improved in version 3. In this mode, the configuration is separated into 2 distinct sections, one which contains the library options, and another which defines the functions and classes to export, views, as well as their options.

#### The library mode

This mode was inherited from Xajax. In this mode, the configuration of Jaxon contains library the options, and optionally those of the response plugins.

Here is an example of a configuration file.

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

These options are described [in the documentation](/docs/v3x/about/configuration.html).
The `core` block contains the general options of Jaxon, the `js` block defines the options of the javascript part, and the `assets` block concerns the processing of static files and third-party libraries (CSS and javascript ).

The `dialogs` block defines the options of the [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) library.

#### The application mode

In this mode, the configuration is separated into two parts.
The first part contains the options of the Jaxon library, which are presented in the previous paragraph.
The second contains declarations for the PHP functions and classes to export, the views, as well as their options.
Two other types of options exist, to define dependency injection for classes, and to include third-party packages in the application.

The main advantage of this mode is to allow Jaxon to be bootstrapped entirely from its configuration file, and therefore to be able to [start and be used](/docs/v3x/advanced/bootstrap.html) without needing to code the instructions.

Here is an example of a configuration file.

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

The library options are defined under the `lib` key. They have already been presented in the previous section.

The application options are defined under the `app` key.

The `functions`, `classes` and `directories` blocks respectively contain [functions](/docs/v3x/registrations/functions.html), [individual classes](/docs/v3x/registrations/classes.html), and [class directories](/docs/v3x/registrations/directories.html) registrations. Directories can be associated with [namespaces](/docs/v3x/registrations/namespaces.html).

The `container` block contains [dependency injection](/docs/v3x/advanced/dependency-injection.html) définitions for the exported classes. This functionality is very important in version 3 of Jaxon, where the exported classes can no longer be instantiated by the developer. It is then the only way to have parameters in the constructors of these classes.

The `views` block contains [the views](/docs/v3x/advanced/views.html) declarations. Different template engines can be used, but always with the same API. If Jaxon is used with a PHP framework, the API also gives access to the views defined in the framework.

The `options` block defines the options specific to the views.

Finally, the `packages` block allows to include third-party [packages](/docs/v3x/plugins/packages.html) in the application.
The configuration of a package can itself have `functions`, `classes`, `directories`, `container` and `views` blocks, and the data they define will be combined with those of the application.
This is the feature which allows a Jaxon package to enrich an application with a full set of functionalities both in the backend and the frontend.

#### In conclusion

The *application mode* is the recommended one when using the Jaxon library in version 3.
It is simpler because the amount of code to write for the library to start and run is kept to a minimum, one line in most cases.
