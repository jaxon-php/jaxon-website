---
title: View extensions
menu: View extensions
template: jaxon
---

Jaxon provides a generic [view display API](../../ui-features/views.html) that can be adapted to various templating engines.
A view extension connects a templating engine to this API.

#### Create a view extension

A view extension must implement the `Jaxon\App\View\ViewInterface` interface.

```php
namespace Jaxon\App\View;

interface ViewInterface
{
    /**
     * Add a namespace to the view renderer
     *
     * @param string $sNamespace    The namespace name
     * @param string $sDirectory    The namespace directory
     * @param string $sExtension    The extension to append to template names
     *
     * @return void
     */
    public function addNamespace(string $sNamespace, string $sDirectory, string $sExtension = '');

    /**
     * Render a view
     *
     * @param Store $store    A store populated with the view data
     *
     * @return string
     */
    public function render(Store $store): string;
}
```

The `addNamespace()` function declares a template directory in the engine, associating it with a namespace and optionally an extension.
The `render()` function displays a view based on parameters stored in a `Jaxon\App\View\Store` object, which contains its name, namespace, and all parameters passed to it.

The extension must be declared with the library, passing its id and a callback that instantiates it.
For example, the [Twig](https://github.com/jaxon-php/jaxon-twig) extension is declared with the following call.

```php
jaxon()->di()->getViewRenderer()->addRenderer('twig', function () {
    return new Jaxon\Twig\View();
});
```

#### Template functions

A view extension can also add functions to the template engine for [insert generated code](../../registrations/javascript.html), [UI components](../../components/node-components.html), or [call factories](../../ui-features/call-factories.html).
These are typically the following functions.

Code generation.
- jxnCss(): inserts the library's CSS code.
- jxnJs(): inserts the library's Javascript code.
- jxnScript(): inserts the library's export code.

Managing UI components.
- jxnBind(): attaches a component to a DOM element.
- jxnHtml(): inserts the HTML code of a component.
- jxnPagination(): attaches a pagination component to a DOM element.

Event handlers.
- jxnOn(): defines an event handler.
- jxnClick(): defines a handler for the `click` event.
- jxnEvent(): defines event handlers.
- rq(): `call factory` for an exported object.
- jo(): `call factory` for a Javascript object.
- jq(): `call factory` for a jQuery selector.
- je(): `call factory` for a Javascript selector.
