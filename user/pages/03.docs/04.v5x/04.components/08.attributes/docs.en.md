---
title: Attributes and annotations
menu: Attributes and annotations
template: jaxon
---

Attributes and annotations are optional and provided in the [`jaxon-php\jaxon-attributes`](https://github.com/jaxon-php\jaxon-attributes) and [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) packages.
However, they are recommended because they simplify the use of other functions by allowing their configuration parameters to be defined in Jaxon class files, rather than in the configuration file.

In classes registered in the Jaxon configuration file, only one of these two functions can be used.
Therefore, a choice must be made between attributes and annotations.
However, within a package, it is possible to make a different choice. But again, only one of these two functions can be used in all classes within the package.
Ultimately, to use both attributes and annotations simultaneously in the same application, the classes that use a different function must be moved into a separate package.

### Configuration

In order to use attributes or annotations in an application, the `app.metadata.format` configuration option must be set to one of the values ​​`attributes` or `annotations`.
In a package, the option to be set is `metadata.format`.

```php
    'app' => [
        'metadata' => [
            'format' => 'attributes',
        ],
        'packages' => [
            My\Sample\Package::class => [
                'metadata' => [
                    'format' => 'annotations',
                ],
            ],
        ],
    ],
```

### Cache metadata

It is possible to define a cache directory, in which the data from the processing of attributes and annotations will be saved, to avoid processing them with each request to the application.

```php
    'app' => [
        'metadata' => [
            'format' => 'attributes',
            'cache' => [
                'enabled' => true,
                'dir' => '/path/to/the/metadata/cache',
            ]
        ],
        'packages' => [
            My\Sample\Package::class => [
                'metadata' => [
                    'format' => 'annotations',
                ],
            ],
        ],
    ],
```

### Available attributes and annotations

> Note: when an attribute or annotation is defined on a method, it must be a public method, which except for the `Jaxon\Attributes\Attribute\Export` attribute and the `@export` annotation, is exported to Javascript.

#### Dependency injection

The `Jaxon\Attributes\Attribute\Inject` attribute and the `@di` annotation allow to configure the [dependency injection](../../features/dependency-injection.html).
They can be defined on classes, methods, or protected and public properties.

#### Data bags

The `Jaxon\Attributes\Attribute\Databag` attribute and the `@databag` annotation allow to configure the [data bags](../databags.html).
They can be defined on classes or methods.

#### File upload

The `Jaxon\Attributes\Attribute\Upload` attribute and the `@upload` annotation allow to configure the [file upload](../../features/upload.html).
They can be defined on methods only.

#### Hooks

The `Jaxon\Attributes\Attribute\Before` and `Jaxon\Attributes\Attribute\After` attributes, as well as the `@before` and `@after` annotations, allow to configure the [callbacks](../../features/hooks.html) to call before or after the requested method.
They can be defined on classes or methods.

#### Exclude classes or methods

The `Jaxon\Attributes\Attribute\Exclude` attribute and the `@exclude` annotation allow to exclude classes or public methods from the [generated Javascript code](../../registrations/options.html).

#### Choose the methods to be exported

The `Jaxon\Attributes\Attribute\Export` attribute and the `@export` annotation allow to configure a little more detail the methods that should be exported to Javascript.
They can be defined on classes only.
