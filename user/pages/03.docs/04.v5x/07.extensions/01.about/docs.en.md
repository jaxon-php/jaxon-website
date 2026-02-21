---
title: Extending the library
menu: Extensions
template: jaxon
---

The Jaxon library's architecture is modular.
Many of its functions are designed as extensions that are integrated into the core library.
This is for example the case of the features of declaring classes and functions to be exported, as well as databags.

The library's features can therefore be enhanced with several types of extensions.

[Response plugins](../response.html) are the most common. They add new functionality to the `Response` object and implement advanced UI features, such as dialogs or uploads.

[Request plugins](../request.html) are less frequent. They add new types of objects to be registered into the library, in addition to classes and functions.
Then, they generate the corresponding Javascript code, and they process the Ajax requests sent to these objects.

[View extensions](../views.html) connect template engines to the Jaxon's view rendering API.

The [Dialogs plugin](../../ui-features/dialogs.html) is a special case in the Jaxon universe. It is a [response plugin](../response.html), but it can also be extended with [it own plugins](../dialogs.html).

[Integration extensions](../../integrations/about.html) do not enrich the library's functionality, but rather serve to simplify its use with the most common PHP frameworks or CMSs, such as Laravel or Symfony.

[Packages](../packages.html) are complete software modules that implement the backend and frontend features of a solution. They are designed to be integrated into a page of an existing PHP application.

#### Extension interfaces

The Jaxon library defines several interfaces that extension classes must implement, depending on the functions they provide.

The `Jaxon\Plugin\PluginInterface` interface is common to both response and request plugins.

Response plugins must also implement the `Jaxon\Plugin\ResponsePluginInterface` interface.
These interfaces are grouped in the abstract class `Jaxon\Plugin\AbstractResponsePlugin`.

Request plugins must implement the `Jaxon\Plugin\CallableRegistryInterface` interface when they need to declare classes that can be called in an Ajax request, and the `RequestHandlerInterface` interface when they can process a request.
These interfaces are grouped in the abstract class `Jaxon\Plugin\AbstractRequestPlugin`.

View extensions must implement the `Jaxon\App\View\ViewInterface` interface.
Packages must inherit from the abstract class `Jaxon\Plugin\AbstractPackage`, but do not have any interface to implement.

#### Code generation interfaces

In addition to the extension interfaces, the library provides specific interfaces for extensions that generate Javascript or CSS code.
These are the interfaces `Jaxon\Plugin\JsCodeGeneratorInterface` and `Jaxon\Plugin\CssCodeGeneratorInterface`.

In addition to the `getHash()` function, each defines a `getJsCode()` or `getCssCode()` function, which must return a `Jaxon\Plugin\JsCode` or `Jaxon\Plugin\CssCode` object.
The implementation of the code generation functions will therefore consist of creating an instance of one of these classes and populating its properties with the extension's code.

> Note: the `Jaxon\Plugin\CodeGeneratorInterface` interface is deprecated.
