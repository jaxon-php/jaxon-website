---
title: Extending the library
menu: Extensions
template: jaxon
---

The Jaxon library's architecture is modular.
Many of its functions are designed as extensions that are integrated into the core library.
This is for example the case of the features of declaring classes and functions to be exported, as well as databags and pagination.

The library's features can therefore be enhanced with several types of extensions.

[Response plugins](../response.html) are the most common. They add new functionality to the `Response` object and implement advanced UI features, such as dialogs or uploads.

[Request plugins](../request.html) are less frequent. They add new types of objects to be registered into the library, in addition to classes and functions, they generate the corresponding Javascript code, and they process the Ajax requests sent to these objects.

[View extensions](../views.html) connect template engines to the Jaxon's view rendering API.

The [Dialogs plugin](../../ui-features/dialogs.html) is a special case in the Jaxon universe. It is a [response plugin](../response.html), but it can also be extended with [it own plugins](../dialogs.html).

[Integration extensions](../../integrations/about.html) do not enrich the library's functionality, but rather serve to simplify its use with the most common PHP frameworks or CMSs, such as Laravel or Symfony.

[Packages](../packages.html) are complete software modules that implement the backend and frontend features of a solution. They are designed to be integrated into a page of an existing PHP application.

#### Common interfaces for plugins

Each extension type must implement certain specific interfaces.
However, two interfaces are common to several extension types.

The `Jaxon\Plugin\PluginInterface` interface is mandatory for both request plugins and response plugins.
It defines a name for the plugin.

```php
namespace Jaxon\Plugin;

interface PluginInterface
{
    /**
     * Get a unique name to identify the plugin.
     *
     * @return string
     */
    public function getName(): string;
}
```

The `Jaxon\Plugin\CodeGeneratorInterface` interface can be implemented by any extension that needs to add Javascript or CSS code to the application.
It defines the functions that generate the codes.

```php
namespace Jaxon\Plugin;

use Jaxon\Plugin\Code\JsCode;

interface CodeGeneratorInterface
{
    /**
     * Get the value to be hashed
     *
     * @return string
     */
    public function getHash(): string;

    /**
     * Get the HTML tags to include CSS code and files into the page
     *
     * The code must be enclosed in the appropriate HTML tags.
     *
     * @return string
     */
    public function getCss(): string;

    /**
     * Get the HTML tags to include javascript code and files into the page
     *
     * The code must be enclosed in the appropriate HTML tags.
     *
     * @return string
     */
    public function getJs(): string;

    /**
     * Get the javascript code to include into the page
     *
     * The code must NOT be enclosed in HTML tags.
     *
     * @return string
     */
    public function getScript(): string;

    /**
     * Get the javascript codes to include into the page
     *
     * The code must NOT be enclosed in HTML tags.
     *
     * @return JsCode|null
     */
    public function getJsCode(): ?JsCode;
}
```
