---
title: Framework integration extensions
menu: Integration extensions
template: jaxon
---

Jaxon provides many extensions to facilitate integration with the most popular PHP frameworks.

These Jaxon extensions use the framework's features to:
- Bootstrap the library from a framework-formatted configuration file.
- Create a route and controller (or middleware) to process Jaxon requests.
- Convert the response to be sent back to the browser to the framework's format.

The extensions will also provide proxy features for:
- Logs: the messages written with Jaxon's [logging functions](../../features/logging.html) are sent to the framework's logging system.
- Views: Jaxon's [view functions](../../ui-features/views.html) display templates defined in the framework.
- Container: the services defined in the framework's dependency container can be [injected into Jaxon classes](../../features/dependency-injection.html).
- Sessions: Jaxon's [session functions](../../features/sessions.html) allow to read and write values ​​in the framework's sessions.

Finally, for the views, the extensions define functions to insert Jaxon's Javascript and CSS codes, and [call factories](../../ui-features/call-factories.html).
