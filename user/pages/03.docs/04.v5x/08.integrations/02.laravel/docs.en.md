---
title: Laravel integration
menu: Laravel
template: jaxon
---

[The Jaxon extension for Laravel](https://github.com/jaxon-php/jaxon-laravel) installs with `Composer`.

```bash
composer install jaxon-php/jaxon-laravel
```

The `5.x` version of the extension is compatible with all versions of the framework starting from `7.0`.

#### Extension features

It bootstraps the library from the `config/jaxon.php` file, and provides all the [features of the integration extensions](../about.html).

It provides two middlewares to initialize the Jaxon library and creates the route to process Jaxon requests.
It also provides proxy features for logging, view, dependency injection, and session management functions.

#### Blade directives

In Blade views, the `jxnCss`, `jxnJs`, and `jxnScript` directives insert Jaxon CSS and Javascript codes into templates.

```php
// resources/views/demo/index.blade.php

<!-- In page header -->
@jxnCss()
</head>

<body>
<!-- Page content here -->
</body>

<!-- In page footer -->
@jxnJs()

@jxnScript()
```

> **Note** In the following examples, the `rqAppTest` template variable is set to the value `rq(Demo\Ajax\App\AppTest::class)`.

The `jxnBind` directive attaches a UI component to a DOM node, and `jxnHtml` inserts its HTML code into it.

```php
    <div class="col-md-12" @jxnBind($rqAppTest)>
        @jxnHtml($rqAppTest)
    </div>
```

The `jxnPagination` directive inserts the [pagination links](../../ui-features/pagination.html) of a component's function into a template.

```php
    <div class="col-md-12" @jxnPagination($rqAppTest)>
    </div>
```

The `@jxnOn` directive binds an event on a DOM element to a Javascript call defined using a `call factory`.

```php
    <select class="form-select"
        @jxnOn('change', $rqAppTest->setColor(jq()->val()))>
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
```

The `@jxnClick` directive is a shortcut to define a handler for the `click` event.

```php
    <button type="button" class="btn btn-primary"
        @jxnClick($rqAppTest->sayHello(true))>Click me</button>
```

The `@jxnEvent` directive defines a set of events handlers on the children of a DOM elements, using `jQuery` selectors.

```php
    <div class="row" @jxnEvent([
        ['.app-color-choice', 'change', $rqAppTest->setColor(jq()->val())]
        ['.ext-color-choice', 'change', $rqExtTest->setColor(jq()->val())]
    ])>
        <div class="col-md-12">
            <select class="form-control app-color-choice">
                <option value="black" selected="selected">Black</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
            </select>
        </div>
        <div class="col-md-12">
            <select class="form-control ext-color-choice">
                <option value="black" selected="selected">Black</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
            </select>
        </div>
    </div>
```

The `@jxnEvent` directive takes as parameter an array in which each entry is an array with a `jQuery` selector, an event and a `call factory`.

#### The demo application

The demo application in the repo [https://github.com/jaxon-php/jaxon-demo-laravel](https://github.com/jaxon-php/jaxon-demo-laravel) integrates the extension into Laravel version 9.

![Laravel demo](/images/jaxon-demo-laravel.png)

It displays in the same page the form used in [the examples](https://github.com/jaxon-php/jaxon-examples), which is built here with Blade templates, and a calculator implemented in a package and whose code is in the repo [https://github.com/jaxon-php/jaxon-demo-calc](https://github.com/jaxon-php/jaxon-demo-calc).
