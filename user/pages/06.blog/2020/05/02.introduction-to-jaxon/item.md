---
title: 'Introduction to Jaxon'
date: '10-05-2020 08:00'
media:
    images:
        - markus-spiske-unsplash.jpg
taxonomy:
    category:
        - blog
    tag:
        - php
        - javascript
        - ajax
---

Jaxon is a fork of the [Xajax PHP library](http://www.xajax-project.org) which allows to create [Ajax applications with PHP](/features/operation/lifecycle.html). It exports PHP classes to javascript, so they can be called from a browser.
It then provides a set of functions that can be used to define a webpage content and layout from these classes. At the end, a single javascript call can execute a set of complex actions on a webpage, which are defined in PHP on the server.

Unfortunately, the development of Xajax was suspended in 2012, short after the release of version 0.6.
In July 2016, the 1.0.0 version of Jaxon was released. It took over the main features of Xajax, but with a completely re-written code. It is now separated into one [javascript package](https://github.com/jaxon-php/jaxon-js), one [main PHP package](https://github.com/jaxon-php/jaxon-core), and several extensions.

The latest stable version of the Jaxon library is the `3.2.1`.

#### Jaxon features

[The version 3 of Jaxon](/docs/v3x.html) comes with improved extensibility and configuration.
A new type of plugin was introduced: [the packages](/docs/v3x/plugins/packages.html), and it is now possible to bootstrap the library from a [single configuration file](/docs/v3x/advanced/bootstrap.html).
Another important new feature, the [Jaxon classes](/docs/v3x/registrations/classes.html) do not need to be instantiated anymore when they are registered into the library.

The other features that was introduced in previous versions are still available: exporting directories and namespaces, uploading files, Ajax requests generation and pagination, etc.

#### Jaxon extensions

The Jaxon library provides 3 types of extensions.

[The response plugins](/docs/v3x/plugins/response.html) extend the `Jaxon\Response\Response` object, and add new features into a webpage, such as showing notifications or displaying graphs.

[The integration plugins](/docs/v3x/plugins/frameworks.html) simplify the usage of Jaxon with existing PHP frameworks, and implement unified APIs for features such as view management or sessions.

[The packages](/docs/v3x/plugins/packages.html) implement a complete set of frontend and backend features based on Jaxon, which can be provided in a dedicated page in an application.

#### A simple example

In order to show how Jaxon operates, in the following example a simple calculator for integer numbers is created with Jaxon and the Laravel framework. It requires to install Laravel and the [jaxon-core](https://github.com/jaxon-php/jaxon-core), [jaxon-laravel](https://github.com/jaxon-php/jaxon-laravel), and [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) packages.

The Jaxon classes will be located in the `app/Ajax` directory, which in Laravel corresponds to the `App\Ajax` namespace.

Here's the corresponding configuration, to be saved in the `config/jaxon.php` file.

```php
return [
    'app' => [
        'directories' => [
            app_path('Ajax') => [
                'namespace' => '\\App\\Ajax',
                'autoload' => false,
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'app' => [
                'export' => false,
                'minify' => false,
            ],
        ],
        'dialogs' => [
            'default' => [
                'message' => 'toastr',
            ],
            'toastr' => [
                'options' => [
                    'closeButton' => true,
                    'positionClass' => 'toast-top-center'
                ],
            ],
        ],
    ],
];
```

The Jaxon classes directory and namespace are defined in the `app.directories` section. The `autoload` parameter is set to `false` because the directory is already autoloaded by Laravel.
The parameters in the `lib.dialogs` section indicate that the notifications will be displayed using the [Toastr](https://codeseven.github.io/toastr/) library.

This is the code of the `Calculator` class, to be saved into the `app/Ajax/Calculator.php` file.

```php
namespace App\Ajax;

use Jaxon\CallableClass;

class Calculator extends CallableClass
{
    public function calculate($firstOperand, $secondOperand, $operation)
    {
        $firstOperand = intval($firstOperand);
        $secondOperand = intval($secondOperand);
        $result = '';
        switch($operation)
        {
        case 'a':
            $result = $firstOperand + $secondOperand;
            break;
        case 's':
            $result = $firstOperand - $secondOperand;
            break;
        case 'm':
            $result = $firstOperand * $secondOperand;
            break;
        case 'd':
            if($secondOperand == 0)
            {
                $this->response->dialog->error('Cannot divide by zero.', 'Error');
                return;
            }
            $result = $firstOperand / $secondOperand;
            break;
        default:
            $this->response->dialog->error("Operation '$operation' not supported.", 'Error');
            return;
        }

        $this->response->assign('result', 'innerHTML', "$result");
        return $this->response;
    }
}
```

The `calculate()` method will be called from the browser.
The call to `$this->response->dialog->error()` uses the `jaxon-dialogs` plugin to display an error message on the screen.
The call to `$this->response->assign()` displays the result in the HTML element whose `id` property value is `result`.

The following Laravel controller prints the page.

```php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Ajax\Calculator;
use Jaxon\Laravel\Jaxon;

class DemoController extends Controller
{
    public function index(Jaxon $jaxon)
    {
        // Jaxon request to the Calculator class
        $calculatorRequest = $jaxon->request(Calculator::class);
        // Ajax call to a method in the Calculator class
        $calculatorCall = $calculatorRequest->calculate(pm()->input('first_operand'),
            pm()->input('second_operand'), pm()->select('operation'));

        // Print the page
        return view('demo/index', [
            'jaxonCss' => $jaxon->css(),
            'jaxonScript' => $jaxon->script(true),
            // Ajax call to a method in the Calculator class
            'calculatorCall' => $calculatorCall,
        ]);
    }
}
```

The call to `$jaxon->request()` returns a [Jaxon request](/docs/v3x/requests/factory.html) to the `Calculator` class, which is then used to generate the Ajax call to the PHP `calculate()` method.
The contents of the HTML elements in the webpage are passed as parameters to the Ajax call using the `pm()` function.

The `css()` and `script()` methods of the Jaxon plugin for Laravel return the [CSS and javascript codes](/docs/v3x/registrations/javascript.html) to be inserted in the webpage.

The following HTML code is the content of the page, to be inserted into the `demo/index.blade.php` template.

```html
<div class="row">
    <div class="col-md-2">
        <input class="form-control" id="first_operand" type="text" />
    </div>
    <div class="col-md-2">
        <select class="form-control" id="operation">
            <option value="a">+</option>
            <option value="s">-</option>
            <option value="m">*</option>
            <option value="d">/</option>
        </select>
    </div>
    <div class="col-md-2">
        <input class="form-control" id="second_operand" type="text" />
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-primary btn-sm" onclick="{!! $calculatorCall !!}; return false;" > = </button>
    </div>
    <div class="col-md-2" id="result">
        ???
    </div>
</div>
```

Now to finish, the CSS and javascript codes of Jaxon must be inserted into the `demo/index.blade.php` template using the `{!! $jaxonCss !!}` and `{!! jaxonScript !!}` variables.

That's how Jaxon allows to make calls to a PHP class from a webpage, and to update the webpage from that PHP class.
