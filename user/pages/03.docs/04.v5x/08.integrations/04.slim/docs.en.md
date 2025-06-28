---
title: Slim Framework integration
menu: Slim Framework
template: jaxon
---

[The Jaxon extension for Slim Framework](https://github.com/jaxon-php/jaxon-slim) installs with `Composer`.

```bash
composer install jaxon-php/jaxon-slim
```

The `5.x` version of the extension is compatible with the version `4` of the framework.

#### Extension features

The extension can bootstrap the library from a given configuration file, and provides all the [features of the integration extensions](../about.html), except the session management.

It doesn't implement the functions, but since Slim Framework relies on the PSR standards, the extension makes use of the [Jaxon PSR features](../../about/psr-standards.html) to provide two middlewares to bootstrap the library and process Jaxon requests, and integrate the logging and dependency injection features.

#### Twig functions

In Twig views, the `jxnCss`, `jxnJs`, and `jxnScript` functions insert Jaxon CSS and Javascript codes into templates.

```php
{% raw %}
// resources/views/demo/index.blade.php

<!-- In page header -->
{{ jxnCss() }}
</head>

<body>
<!-- Page content here -->
</body>

<!-- In page footer -->
{{ jxnJs() }}

{{ jxnScript() }}
{% endraw %}
```

> **Note** In the following examples, the `rqAppTest` template variable is set to the value `rq(Demo\Ajax\App\AppTest::class)`.

The `jxnBind` function attaches a UI component to a DOM node, and `jxnHtml` inserts its HTML code into it.

```php
{% raw %}
    <div class="col-md-12" {{ jxnBind(rqAppTest) }}>
        {{ jxnHtml(rqAppTest) }}
    </div>
{% endraw %}
```

The `jxnPagination` function inserts the [pagination links](../../ui-features/pagination.html) of a component's function into a template.

```php
{% raw %}
    <div class="col-md-12" {{ jxnPagination(rqAppTest) }}>
    </div>
{% endraw %}
```

The `@jxnOn` function binds an event on a DOM element to a Javascript call defined using a `call factory`.

```php
{% raw %}
    <select class="form-select"
        {{ jxnOn('change', rqAppTest.setColor(jq().val())) }}>
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
{% endraw %}
```

The `@jxnClick` function is a shortcut to define a handler for the `click` event.

```php
{% raw %}
    <button type="button" class="btn btn-primary"
        {{ jxnClick(rqAppTest.sayHello(true)) }}>Click me</button>
{% endraw %}
```

The `@jxnEvent` function defines a set of events handlers on the children of a DOM elements, using `jQuery` selectors.

```php
{% raw %}
    <div class="row" {{ jxnEvent([
        ['.app-color-choice', 'change', rqAppTest.setColor(jq().val())]
        ['.ext-color-choice', 'change', rqExtTest.setColor(jq().val())]
    ]) }}>
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
{% endraw %}
```

The `@jxnEvent` function takes as parameter an array in which each entry is an array with a `jQuery` selector, an event and a `call factory`.

The `jxnBind`, `jxnHtml`, `jxnPagination`, `jxnOn`, `jxnClick`, and `jxnEvent` functions are also defined as Twig filters.
They can therefore be called with a different syntax.

```php
{% raw %}
    <div class="col-md-12" {{ rqAppTest|jxnBind }}>
        {{ rqAppTest|jxnHtml }}
    </div>
{% endraw %}
```

Finally, the [call factory functions](../../ui-features/call-factories.html) `jq`, `je`, `jo` and `rq` are also defined as Twig functions.

#### The demo application

The demo application in the repo [https://github.com/jaxon-php/jaxon-demo-slim](https://github.com/jaxon-php/jaxon-demo-slim) integrates the extension into Slim Framework version 4.

![Slim Framework demo](/images/jaxon-demo-slim.png)

It displays in the same page the form used in [the examples](https://github.com/jaxon-php/jaxon-examples), which is built here with Twig templates, and a calculator implemented in a package and whose code is in the repo [https://github.com/jaxon-php/jaxon-demo-calc](https://github.com/jaxon-php/jaxon-demo-calc).
