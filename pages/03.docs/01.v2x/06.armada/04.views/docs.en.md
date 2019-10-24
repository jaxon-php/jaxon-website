---
title: The views
menu: The views
template: jaxon
---

Armada provides a simple and unique API to render views, which can be used with various template engines.

#### The installation

In order to be able to render views with a given template engine, the corresponding package must first be installed.
Packages currently exist for 6 template engines.

- [Twig](https://twig.sensiolabs.org) https://github.com/jaxon-php/jaxon-twig. Its identifier is `twig`.
- [Smarty](http://www.smarty.net) https://github.com/jaxon-php/jaxon-smarty. Its identifier is `smarty`.
- [Blade](https://laravel.com/docs/master/blade) https://github.com/jaxon-php/jaxon-blade. Its identifier is `blade`.
- [Dwoo](http://dwoo.org) https://github.com/jaxon-php/jaxon-dwoo. Its identifier is `dwoo`.
- [Latte](https://latte.nette.org) https://github.com/jaxon-php/jaxon-latte. Its identifier is `latte`.
- [RainTpl](https://feulf.github.io/raintpl) https://github.com/jaxon-php/jaxon-raintpl. Its identifier is `raintpl`.

Many of them can be used simultaneously in the same Armada application.

#### The configuration

The `app.views` section of the Armada configuration contains an array of directories where the views are found.
Each entry of the array defines a directory, with the following informations:

- `directory` : the full path of the directory.
- `extension` : the extension of the view files in the directory.
- `renderer` : the identifier of the template engine to be used to render the views in this directory.
- `register` : optional, tells if the directory shall be registered in the template engine, `true` by default.

The key of each entry of the array is a unique identifier, which will be used when rendering a view to get the directory where to find the corresponding file.

#### The rendering

The following configuration defines the directory `/path/to/users/views`, containing Smarty templates.

```php
    'app' => array(
        'views' => array(
            'users' => array(
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ),
        ),
    ),
```

The following call renders the template in the file `/path/to/users/views/path/to/view.tpl` with the Smarty engine.

```php
    $html = $this->view()->render('users::path/to/view');
```

If a default namespace is added in the configuration, then the identifier can be omitted in the call.

```php
    'app' => array(
        'views' => array(
            'users' => array(
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ),
        ),
        'options' => array(
            'views' => array(
                'default' => 'users',
            ), 
        ),
    ),
```

```php
    $html = $this->view()->render('path/to/view');
```

#### The variables

The following functions insert variables into views.

The `share()` function makes a variable available in all views.

```php
    $this->view()->share('count', 5);
```

The `set()` function makes a variable available in the next view to be rendered. It can be chained with the `render()` function.

```php
    $this->view()->set('count', 5)->set('current', 1)->render('path/to/view');
```

The `with()` function adds a variable to the view returned by the `render()` function.

```php
    $this->view()->render('path/to/view')->with('count', 5)->with('current', 1);
```

Variables can also be inserted into a view by passing an array as second parameter to the `render()` function.

```php
    $this->view()->render('path/to/view', array('count' => 5, 'current' => 1));
```

#### Adding a template engine

Adding a template engine to Armada is done by creating a class that implements the `Jaxon\Sentry\Interfaces\View` interface, which is defined in the `jaxon-sentry` package.

```php
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
    public function render(\Jaxon\Sentry\View\Store $store);
}
```

The `addNamespace()` method is called for each directory associated with the template engine in the configuration.
The `render()` method returns the HTML code of a given view. It takes as a parameter an object of class `\Jaxon\Sentry\View\Store`, which contains the view data.

After the class is defined, it must be registered with Armada using the following call.

```php
jaxon()->armada()->addViewRenderer($myViewId, function(){
    return new View();
});
```

The `$myViewId` parameter is the identifier which will be later set as value of the `renderer` option in the configuration.
