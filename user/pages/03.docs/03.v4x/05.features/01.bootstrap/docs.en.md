---
title: Bootstrapping
menu: Bootstrapping
template: jaxon
---

The Jaxon library can bootstrap from a single configuration file, which defines all the inputs the library needs in order to operate: functions, classes, views, and all the other config options.


```php
// Configuration
jaxon()->app()->setup('/path/to/config.php');
```

The configuration file has two main sections, identified with the `app` and` lib` keywords.

The `lib` section contains the configuration options of the library, and its plugins.

The `app` section contains the configuration options for application level features like classes and functions registration, or views.

#### The functions

The `app.functions` section of the configuration contains an array of functions to be registered.

Here's an example.

```php
    'app' => [
        'functions' => [
            'hello_world',
            'sayhello',
        ],
    ],
```

Options can be set on functions.

```php
    'app' => [
        'functions' => [
            'hello_world' => [
                'mode' => "'asynchronous'",
            ],
        ],
    ],
```

#### The classes

The `app.classes` section of the configuration contains an array of classes to be registered.

Here's an example.

```php
    'app' => [
        'classes' => [
            'HelloWorld',
            'OtherClass',
        ],
    ],
```

Options can be set on class methods.

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

#### The directories

The `app.directories` section of the configuration contains an array of directories where the classes to be registered are found.
Each entry of the array represents a directory, defined with its full path and the following informations:

- `namespace` : optional, the associated namespace.
- `autoload` : optional, boolean, if true (default), the classes in the directory are autoloaded.
- `separator` : optional, the separator to be used in javascript class names, can be `.` (by default) or `_`.
- `protected` : optional, an array of methods that are not to be exported in javascript classes, empty by default.

Here's an example.

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

Options can be set on class methods.

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
