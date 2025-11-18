---
title: Bootstrapping
menu: Bootstrapping
template: jaxon
---

The Jaxon library can bootstrap from a single configuration file, which defines all the inputs the library needs in order to operate: functions, classes, views, and config options.


```php
// Configuration
jaxon()->app()->setup('/path/to/config.php');
```

The configuration file has two main sections, identified with the `app` and` lib` keywords.

The `lib` section contains the configuration options of the library, and its plugins.

The `app` section contains the configuration options of the functions, classes and views.

#### Les fonctions

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
                'setColor' => [
                    'mode' => "'synchronous'"
                ],
                '*' => [
                    'mode' => "'asynchronous'"
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
            ],
        ],
    ],
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
                \Jaxon\App\Test\Bts::class => [
                    '*' => [
                        'mode' => "'asynchronous'",
                    ]
                ]
            ],
        ],
    ],
```

#### The views

The `app.views` section of the Armada configuration contains an array of directories where the views are found.
Each entry of the array defines a directory, with the following informations:

- `directory` : the full path of the directory.
- `extension` : the extension of the view files in the directory.
- `renderer` : the identifier of the template engine to be used to render the views in this directory.

The key of each entry of the array is a unique identifier, which will be used when rendering a view to get the directory where to find the corresponding file.

The following configuration defines the directory `/path/to/users/views`, containing Smarty templates.

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

The following call renders the template in the file `/path/to/users/views/path/to/view.tpl` with the Smarty engine.

```php
    $html = jaxon()->view()->render('users::path/to/view');
```

If a default namespace is set in the configuration, then the identifier can be omitted in the call.

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

#### The pagination view

With Armada, the pagination links can be printed using any template engine (see the [views documentation](/docs/armada/views.html)).
In order to customize the pagination, create all the required templates in a directory, and then change the views configuration accordingly.

```php
        'views' => [
            'pagination' => [
                'directory' => '/path/to/the/directory',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ],
        ],
```

For example, this is the content of the `/path/to/the/directory/wrapper.tpl`, which is a Smarty template.

```html
{if !empty($prev)}
{$prev}
{/if}
{$links}
{if !empty($next)}
{$next}
{/if}
```
