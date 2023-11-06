---
title: Dependency Injection
menu: Dependency Injection
template: jaxon
---

Starting from version 3, the Jaxon library allows to add classes and interfaces as parameters of Jaxon classes constructors.

The dependency containter is configured when either at library initialization, or in its [configuration file](../01.bootstrap/).
The dependencies are passed to Jaxon classes in their contructor, or using an annotation.

### The dependency container

The dependency containter is returned by a call to `jaxon()->di()`.
It provides four functions that can be used to setup dependencies.

Define the function that returns a dependency.

```php
jaxon()->di()->set(\Name\Space\Class\Name::class, function($di) {
    // Return an instance of the class.
    // Other values in the container can be accessed using the $di variable.
});
```

Automatically discover the class dependencies by analysing its constructor.

```php
jaxon()->di()->auto(\Name\Space\Auto\Name::class);
```

Define an alias for a dependency,

```php
jaxon()->di()->alias(\Name\Space\Interface\Name::class, \Name\Space\Class\Name::class);
```

Define the value for a dependency.

```php
jaxon()->di()->val('di_var_id', $varValue);
```

The dependencies can also be defined in the [configuration file](../01.bootstrap/).

```php
    'app' => [
        'container' => [
            'set' => [
                \Name\Space\Class\Name::class => function($di) {
                    // Return an instance of the class.
                    // Other values in the container can be accessed using the $di variable.
                }
            ],
            'auto' => [
                \Name\Space\Auto\Name::class,
            ],
            'alias' => [
                \Name\Space\Interface\Name::class => \Name\Space\Class\Name::class
            ],
            'val' => [
                'di_var_id' => $varValue
            ],
        ],
    ],
```

### Using dependencies

The dependencies are passed as parameters to Jaxon classes constructors.

```php
class Test extends \Jaxon\App\CallableClass
{
    protected $service;

    public function __construct(\Name\Space\Class\Name::class $service)
    {
        $this->service = $service;
    }
}
```

It is also possible to declare dependencies with [annotations](../../06.annotations/02.di/), which offer more possibilities.

```php
/**
 * @di $service \Name\Space\Class\Name
 */
class Test extends \Jaxon\App\CallableClass
{
    protected $service;
}
```

Or,

```php
class Test extends \Jaxon\App\CallableClass
{
    /**
     * @di
     * @var \Name\Space\Class\Name
     */
    protected $service;
}
```

Dependencies can also be injected directly in Jaxon class methods.

```php
class Test extends \Jaxon\App\CallableClass
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
        return $this->response;
    }
}
```
