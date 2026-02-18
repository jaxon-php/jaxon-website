---
title: Dependency Injection
menu: Dependency Injection
template: jaxon
---

The Jaxon library allows to add classes and interfaces as parameters of Jaxon classes constructors.

The dependency containter is configured when either at library initialization, or in its [configuration file](../../about/configuration.html).
The dependencies are passed to classes in their contructor, or using an attribute or an annotation.

### The dependency container

The dependency containter is returned by a call to `jaxon()->di()`.
It provides five functions that can be used to setup dependencies.

- Define a function that returns a dependency.

```php
use Jaxon\Di\Container;

jaxon()->di()->set(\Name\Space\Class\Name::class, function(Container $di) {
    // Return an instance of the class.
    // Other values in the container can be accessed using the $di variable.
});
```

- Automatically discover the class dependencies by analysing its constructor.

```php
jaxon()->di()->auto(\Name\Space\Auto\Name::class);
```

- Define an alias for a dependency,

```php
jaxon()->di()->alias(\Name\Space\Interface\Name::class, \Name\Space\Class\Name::class);
```

- Define the value for a dependency.

```php
jaxon()->di()->val('di_var_id', $varValue);
```

- Extend a dependency, which must already have been defined.

```php
use Jaxon\Di\Container;

jaxon()->di()->extend(\Name\Space\Class\Name::class, function(mixed $instance, Container $di) {
    // Modify an return an instance of the class.
    // Other values in the container can be accessed using the $di variable.
});
```

The dependencies can also be defined in the [configuration file](../../about/configuration.html).

```php
use Jaxon\Di\Container;

    'app' => [
        'container' => [
            'set' => [
                \Name\Space\Class\Name::class => function(Container $di) {
                    // Return an instance of the class.
                    // Other values in the container can be accessed using the $di variable.
                },
            ],
            'auto' => [
                \Name\Space\Auto\Name::class,
            ],
            'alias' => [
                \Name\Space\Interface\Name::class => \Name\Space\Class\Name::class,
            ],
            'val' => [
                'di_var_id' => $varValue,
            ],
            'extend' => [
                \Name\Space\Class\Name::class => function(mixed $instance, Container $di) {
                    // Modify an return an instance of the class.
                    // Other values in the container can be accessed using the $di variable.
                },
            ],
        ],
    ],
```

### Using dependencies

The dependencies are passed as parameters to classes constructors.

```php
class Test extends \Jaxon\App\FuncComponent
{
    protected $service;

    public function __construct(\Name\Space\Class\Name::class $service)
    {
        $this->service = $service;
    }
}
```

In the Jaxon component classes, it is also possible to declare dependencies with attributes or annotations.

- With attributes.

```php
use Jaxon\Attributes\Attribute\Inject;
use Name\Space\Class\Name;

#[Inject('service', Name::class)]
class Test extends \Jaxon\App\FuncComponent
{
    protected $service;
}
```

- With annotations.

```php
/**
 * @di $service \Name\Space\Class\Name
 */
class Test extends \Jaxon\App\FuncComponent
{
    protected $service;
}
```

Or,

```php
class Test extends \Jaxon\App\FuncComponent
{
    /**
     * @di
     * @var \Name\Space\Class\Name
     */
    protected $service;
}
```

Dependencies can also be injected directly in Jaxon class methods.
In this case, it will only apply on requests to the annotated method.

- With attributes.

```php
use Jaxon\Attributes\Attribute\Inject;
use Name\Space\Class\Name;

class Test extends \Jaxon\App\FuncComponent
{
    /**
     * @var Name
     */
    protected $service;

    #[Inject('service')]
    public function doThat()
    {
        $value = $this->service->do();
        // ...
    }
}
```

- With annotations.

```php
class Test extends \Jaxon\App\FuncComponent
{
    /**
     * @var \Name\Space\Class\Name
     */
    protected $service;

    /**
     * @di $service
     */
    public function doThat()
    {
        $value = $this->service->do();
        // ...
    }
}
```

It is also possible to read a dependency directly into the container.
The container is obtained either by injecting the `Jaxon\Di\Container` class, or with a call to `jaxon()->di()`.

The `g()` and `get()` methods take the identifier of a dependency as a parameter, and return its value.
The `get()` method first looks for the dependency in a third-party container, described in the following paragraph.

### Extend the dependency container

The Jaxon dependency container can be extended using another `PSR-11` container.
This feature is used, for example, when integrating Jaxon into a framework, and makes it possible to inject dependencies defined in the framework's container into Jaxon classes.

```php
use Psr\Container\ContainerInterface;

/**
 * @var ContainerInterface $xContainer
 */
jaxon()->di()->setContainer($xContainer);
```
