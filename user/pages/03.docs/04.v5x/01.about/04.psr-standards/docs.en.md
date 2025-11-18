---
title: Supported PSR standards
menu: PSR standards
template: jaxon
---

Jaxon supports the [HTTP Message Interface (PSR-7)](https://www.php-fig.org/psr/psr-7), [HTTP Handlers (PSR-15)](https://www.php-fig.org/psr/psr-15), and [HTTP Factories (PSR-17)](https://www.php-fig.org/psr/psr-17) standards.

#### PSR-7: HTTP Message Interface

In the `jaxon-core` package and in its request plugins, the HTTP request received as input in the application implements the `Psr\Http\Message\ServerRequestInterface` interface, defined in the PSR-7 standard.

This interface provides functions to read the arguments, the parameters, and the uploaded files from the HTTP request.

The Jaxon classes still return an object of type `Jaxon\Response\ResponseInterface`, but this object now has a `toPsr()` method, which creates an object that implements the `Psr\Http\Message\ResponseInterface` interface, defined by the PSR-7 standard, from its content.

#### PSR-17: HTTP Factories

Jaxon now uses a third-party package that implements the PSR-17 standard, [nyholm/psr7-server](https://github.com/nyholm/psr7-server), to read the HTTP requests it receives.

This package provides functions to create, using the HTTP request content, an object that implements the `Psr\Http\Message\ServerRequestInterface` interface defined by the PSR-7 standard.
This object itself is defined in the [nyholm/psr7](https://github.com/Nyholm/psr7) package.

#### PSR-15: HTTP Handlers

More and more PHP frameworks now support the PSR-15 standard, which defines interfaces for two types of components that process HTTP requests:
- middlewares: `Psr\Http\Server\MiddlewareInterface`,
- request handlers: `Psr\Http\Server\RequestHandlerInterface`.

Jaxon provides two `middlewares` and one `request handler`.

The `jaxon()->psr()->config($filename)` middleware takes the path to a configuration file as a parameter, and bootstraps the library with its content.

The `jaxon()->psr()->ajax()` middleware and the `jaxon()->psr()->handler()` handler process the Jaxon request, and return as response an object that implements the `Psr\Http\Message\ResponseInterface` interface.
Only one of them will typically be used in a single PHP application.

These components will be used when integrating Jaxon with PHP frameworks that support the PSR-15 standard, like the [Slim Framework](../../integrations/slim.html) for example.
