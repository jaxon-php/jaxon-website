---
title: Jaxon extensions
menu: Jaxon extensions
template: jaxon
---

The Jaxon library's architecture is modular.
Many of its functions are designed as extensions that are integrated into the core library.
This is the case of the features of declaring classes and functions to be exported, as well as databags and pagination.

The library's functions can therefore be enhanced with several types of extensions.

[Response plugins](../response.html) are the most common. They add new functionality to the `Response` object and implement advanced UI features, such as dialogs or uploads.

[Request plugins](../request.html) are much rarer. They add new types of objects to be registered into the library, in addition to classes and functions, and they generate the corresponding Javascript code.

[View extensions](../views.html) connect template engines to the Jaxon's view rendering API.

The [Dialog plugin](../../ui-features/dialogs.html) is a special case in the Jaxon universe. It is a [response plugin](../response.html), but it can also be extended with [it own extensions](../dialogs.html).

[Integration extensions](../../integrations/about.html) do not enrich the library's functionality, but rather serve to simplify its use with the most common PHP frameworks or CMSs, such as Laravel or Symfony.

[Jaxon packages](../packages.html) are complete software modules that implement the backend and frontend features of a solution. They are designed to be integrated into a page of an existing PHP application.
