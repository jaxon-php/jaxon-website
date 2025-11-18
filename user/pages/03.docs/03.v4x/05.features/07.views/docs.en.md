---
title: The views
menu: The views
template: jaxon
---

Jaxon provides a simple and extensible API to render views, which can be used with various template engines.

#### The installation

In order to be able to render views with a given template engine, the corresponding package must first be installed.
Packages currently exist for 6 template engines. Many of them can be used simultaneously in the same application.

- [Twig](https://twig.sensiolabs.org) https://github.com/jaxon-php/jaxon-twig. Its identifier is `twig`.
- [Smarty](http://www.smarty.net) https://github.com/jaxon-php/jaxon-smarty. Its identifier is `smarty`.
- [Blade](https://laravel.com/docs/master/blade) https://github.com/jaxon-php/jaxon-blade. Its identifier is `blade`.
- [Latte](https://latte.nette.org) https://github.com/jaxon-php/jaxon-latte. Its identifier is `latte`.

The directories containing the templates and the corresponding template engines must then be declared.

```php
jaxon()->di()->getViewManager()->addNamespace('ns', '/path/to/namespace', '.blade.php', 'blade');
```

A call to `jaxon()->view()->render('ns::path/to/view')` will the render the template `/path/to/namespace/path/to/view.blade.php` with the Blade engine.

#### The variables

The following functions insert variables into views.

The `share()` function makes a variable available in all views.

```php
    jaxon()->view()->share('count', 5);
```

The `set()` function makes a variable available in the next view to be rendered. It can be chained with the `render()` function.

```php
    jaxon()->view()->set('count', 5)->set('current', 1)->render('ns::path/to/view');
```

The `with()` function adds a variable to the view returned by the `render()` function.

```php
    jaxon()->view()->render('ns::path/to/view')->with('count', 5)->with('current', 1);
```

Variables can also be inserted into a view by passing an array as second parameter to the `render()` function.

```php
    jaxon()->view()->render('ns::path/to/view', ['count' => 5, 'current' => 1]);
```

#### Adding a template engine

Adding a new template engine to Jaxon requires the creation and declaration of a class that implements the `Jaxon\Contracts\View` interface.

```php
namespace Jaxon\Contracts;

use Jaxon\Utils\View\Store;

interface View
{
    /**
     * Add a namespace to the view renderer
     *
     * @param string        $sNamespace         The namespace name
     * @param string        $sDirectory         The namespace directory
     * @param string        $sExtension         The extension to append to template names
     *
     * @return void
     */
    public function addNamespace($sNamespace, $sDirectory, $sExtension = '');

    /**
     * Render a view
     *
     * @param Store         $store        A store populated with the view data
     *
     * @return string        The string representation of the view
     */
    public function render(Store $store);
}
```

```php
use Jaxon\Contracts\View as ViewContract;

class NewView implements ViewContract
{
}
```

The `addNamespace()` method will be called anytime a directory is associated with the template engine.
The `render()` method returns the HTML code of a given view. It takes as a parameter an instance of class `Jaxon\Utils\View\Store`, which contains the data passed to the view.

After the class is defined, it must be declared using the following call.

```php
jaxon()->di()->getViewManager()->addViewRenderer($myViewId, function(){
    return new NewView();
});
```

The `$myViewId` parameter is the unique identifier of the template engine, to be passed to calls to `jaxon()->di()->getViewManager()->addNamespace()`.

#### In config file

The views can also be defined in the `app.views` section of the Jaxon configuration.

The key of each entry of this section is a unique identifier, which will be used when rendering a view to get the directory where to find the corresponding file.

Each entry of this section defines a directory, with the following informations:

- `directory` : the full path of the directory.
- `extension` : the extension of the view files in the directory.
- `renderer` : the identifier of the template engine to be used to render the views in this directory.

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
use function Jaxon\jaxon;

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
use function Jaxon\jaxon;

$html = jaxon()->view()->render('path/to/view');
```

#### The pagination view

With Jaxon, the pagination links can be printed using any template engine (see the [views documentation](../views)).

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
