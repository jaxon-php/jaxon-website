---
title: 'Announcing Jaxon version 5'
date: '11-07-2025 07:00'
media:
    images:
        - ben-griffiths-unsplash.jpg
taxonomy:
    category:
        - blog
    tag:
        - release
        - components
        - dialogs
        - laravel
        - symfony
        - php
        - ajax
---

After more than two years of development, the version 5 of the Jaxon library is finally out!

This release is an important step that I think will bring the Jaxon library to the next level, because it implements the features I hoped the library had when I started developing and using it more than ten years ago.

So what's new in this release?

- Exported PHP classes are now called components, and they can be of three different types. Some components can be attached to DOM nodes, and used to set their content.
- The `call factories` in PHP have been enriched, and now support calls to Javascript functions and event handlers, as well as their parameters.
- The command names and formats in responses are now more meaningful, and their processing in Javascript is improved. Deprecated commands have also been removed.
- The dialog libraries now contain only Javascript code, in a single and tiny object. They will therefore be much easier to create and maintain.

Now let's dive more in depth into each of these new features.

### The Jaxon components

In the previous versions of Jaxon, the webpage content was set exclusively using the HTML `id` attribute.

```php
$this->response->html('dom-element-id', $text);
```

Each DOM element in a webpage with dynamic content needed to be given a unique id, which will then be used to update its content. Keeping track of all those ids in an application was not an easy task.

Jaxon 5 introduces a new [UI component](../../../../docs/v5x/components/node-components.html), which is a Jaxon class that defines the content of a DOM element.
It just needs to implement a method named `html()`,

```php
namespace Jaxon\Demo\Calc\App;

class Calc extends \Jaxon\App\NodeComponent
{
    public function html(): \Stringable
    {
        return $this->view()->render('jaxon::demo::calc::calc');
    }
}
```

and to be bound to a DOM element in a webpage.

```php
<div <?= attr()->bind(rq(Jaxon\Demo\Calc\App\Calc::class)) ?>>
</div>
```

The `render()` method in the component can then be used to set the DOM element content, for example with an event handler.

```php
    <button type="button" class="btn btn-primary" <?=
        attr()->click(rq(Jaxon\Demo\Calc\App\Calc::class)->render()) ?>>Clear</button>
```

In this example, a click on the button will display the `jaxon::demo::calc::calc` view in the `div` element the UI component is bound to.

The new components now make it very easy to build complex UI with Jaxon.

### The call and selector factories

Since one of the core features of Jaxon is to write UI components code in PHP on the server, it is important to be able to make calls to Javascript functions, define event handlers, and last but not the least, pass the contents of the webpage as parameters to those calls.
That's the role of the `call factories`.

The `call factories` have been around since the version 2, initially as the [JQuery PHP API](../../../../docs/v2x/advanced/jquery.html).
They have evolved a lot since then, and now they can make calls to the exported Jaxon classes, or to any Javascript function or object.
They can also define event handlers on the webpage elements using Javascript or JQuery-style selectors.
Thirdly, they also provides functions to pass any content of the webpage as parameter to Javascript calls.

In this code from the Jaxon examples, JQuery selectors are used in a Jaxon custom HTML attribute to define calls to Jaxon classes as event handlers on two select lists, and to pass the selected item value as parameter to the handler.

```php
    <div class="row" <?= attr()
        ->select('.app-color-choice')
            ->on('change', rq(AppTest::class)->setColor(jq()->val()))
        ->select('.ext-color-choice')
            ->on('change', rq(ExtTest::class)->setColor(jq()->val())) ?>>
```

In this other example, a command is added in a response to make a call to the `Tontine.makeTableResponsive('content-planning-charge-page')` Javascript code in the browser.

```php
    $this->response->jo('Tontine')
        ->makeTableResponsive('content-planning-charge-page');
```

When building an application UI on the server, being able to make Javascript calls and set event handlers in a webpage is paramount, and the `call factories` provide Jaxon with a powerful set of features to achieve that quite easily.

### Javascript library rewrite

The Javascript library rewrite started as a discusion on Github [about the forbidden usage of eval](https://github.com/jaxon-php/jaxon-js/issues/21).

I then decided to rewrite the Javascript library, which today has resulted in many important changes.

The library now includes a command processor which executes existing Javascript functions from a JSON payload. With this processor, there's no need for the `eval` function anymore, and it is also at the foundation of the `call factories` described above.

The library also includes an attribute processor, which handles the Jaxon custom attributes needed to implement the UI components bindings and the event handlers.
In the example above where the `Jaxon\Demo\Calc\App\Calc` is bound to a `div` element, the following HTML code is actually generated.

```html
<div jxn-bind="Jaxon.Demo.Calc.App.Calc">
...
</div>
```

The [response commands](../../../../docs/v5x/features/responses.html) were also rewritten with new names and a new JSON format. Their names are now more meaningful, and the obsolete ones were removed.

### The dialog plugin

The [dialog plugin](../../../../docs/v5x/ui-features/dialogs.html) is a special case in the Jaxon universe. It is a Jaxon response plugin, but at the same time it can also be extended with it own plugins.

In the previous version, adding a dialog plugin required to write functions in both PHP and Javascript.
In the v5 release, only a tiny Javascript object is now necessary.

This is for example the code of the [Notify](https://notifyjs.jpillora.com/) library integration, which implements the alert function.

```php
jaxon.dom.ready(() => jaxon.dialog.register('notify', (self, options) => {
    // Dialogs options
    const {
        alert: alertOptions = {},
    } = options;

    const xTypes = {
        success: 'success',
        info: 'info',
        warning: 'warn',
        error: 'error',
    };

    /**
     * Show an alert message
     *
     * @param {object} alert The alert parameters
     * @param {string} alert.type The alert type
     * @param {string} alert.message The alert message
     *
     * @returns {void}
     */
    self.alert = ({ type, message }) => {
        $.notify(message, {
            ...alertOptions,
            className: xTypes[type] ?? xTypes.info,
            position: "top center",
        });
    };
}));
```

The only feature in PHP classes is to load the Javascript files into the webpage.

### The examples

A [new example](../../../../docs/v5x/about/example.html) is introduced to illustrate the Jaxon operation.

The example now implements a simple calculator, which takes an operation and two operands as parameters, performs the calculation using an injected service, and displays the result.
There are two text zones and a select combo for the inputs, and the result is displayed in a readonly text zone.

The example is built with the new Jaxon UI components, and also released as a [Jaxon package](https://github.com/jaxon-php/jaxon-demo-calc).
This package is used in the [Laravel](https://github.com/jaxon-php/jaxon-demo-laravel), [Symfony](https://github.com/jaxon-php/jaxon-demo-symfony) and [Slim Framework](https://github.com/jaxon-php/jaxon-demo-clim) demo applications, to show how the Jaxon library can be used to build a cross-framework and full-featured package including both the frontend and backend features.

The [DB Admin](https://github.com/lagdo/dbadmin-mono) package and the [African Tontine](https://github.com/lagdo/tontine) application are also upgraded to Jaxon 5.
Although the former is still a work in progress, both are real world examples of building complex one page Ajax applications with Jaxon.

### Conclusion

The new Jaxon 5 release is packed with features that make it a good choice for creating complex Ajax applications with PHP on the server side.
There are UI components to build the webpage, custom attributes to enrich the HTML code, and powerful `call factories` to make calls to all kind of Javascript functions in PHP.

In addition to the [documentation](../../../../docs.html), there are [many examples](https://github.com/jaxon-php/jaxon-examples) in PHP or with framework integration, and real world open source applications using the library.
