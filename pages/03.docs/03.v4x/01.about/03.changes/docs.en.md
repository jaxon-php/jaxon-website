---
title: Migrating from version 3
menu: Migration from version 3
template: jaxon
---

The following features are impacted by changes from version 3:

- The `Jaxon\App\CallableClass` class
- Namespace for the global functions
- Creation of `Response` objects
- File upload
- Creating plugins

Optionnaly, the following features can take advantage of the new annotations feature.

- Dependency Injection
- Data bags
- File upload

### The `Jaxon\App\CallableClass` class

The `Jaxon\App\CallableClass` class is moved to another namespace.

With version 3
```php
class HelloWorld extends \Jaxon\CallableClass
{
}
```

With version 4
```php
class HelloWorld extends \Jaxon\App\CallableClass
{
}
```

### Namespace for the global functions

In order to avoid conflicts with others libraries, the global functions, `jaxon()`, `pm()`, `rq()` and `jq()`, are now defined in the `Jaxon` namespace.

With version 3
```php
$jaxon = jaxon();
```

With version 4
```php
$jaxon = \Jaxon\jaxon();
```

Or
```php
use function Jaxon\jaxon;

$jaxon = jaxon();
```

### Creation of `Response` objects

The constructor of the `Response` class were modified, and now takes objects provided by the dependency container as parameter.
As a consequence, the creation of `Response` objects now requires to call a method provided by the `Jaxon` class.

With version 3
```php
$response = new Response();
```

With version 4
```php
use function Jaxon\jaxon;

$response = jaxon()->newResponse();
```

The global `Response` object can still be accessed with a call to `jaxon()->getResponse()`.

### File upload

The file upload feature is now provided in a distinct package, and disabled by default.

Implementing file upload with Jaxon now requires to install the [`jaxon-php\jaxon-upload`](https://github.com/jaxon-php\jaxon-upload) package, and set the `core.upload.enabled` option to the boolean value `true`.

However, its usage is still the same as in version 3.

### Creating plugins

New interfaces are defined to describe plugins features.
Depending on the features its provides, a Jaxon plugin must implement one or more of these interfaces.

Concerning the request plugins, `CallableRegistryInterface` for those who register `callables`, `RequestHandlerInterface` for those who process Jaxon requests, and `CodeGeneratorInterface` for those who generate javascript or CSS code.

Concerning the response plugins, there is a single `ResponsePluginInterface` interface.

### Annotations

[Annotations](../../06.annotations/01.about/) are an optional feature provided in the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package.

They are however recommended, since when they are used in a Jaxon class, they highly simplify the implementation of other features.

#### Dependency injection

The `@di` annotation defines objects that are injected in Jaxon classes, either when they are instanciated, or when their methods are called.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    // The $firstService attribute will be automatically set from the
    // dependency container, anytime this class is called.
    /**
     * @di
     * @var FirstService
     */
    protected $firstService;

    /**
     * @var SecondService
     */
    protected $secondService;

    // The $secondService attribute will be automatically set from the
    // dependency container, but only when this method is called.
    /**
     * @di $secondService
     */
    public function doThat()
    {
        // Call the services
        $this->firstService->doSomething();
        $this->secondService->doSomethingElse();

        return $this->response;
    }
}
```

### Data bags

The `@databag` annotation defines data bags, which are data sets that are stored on client side, and made available at demand in Jaxon classes.

```php
// The first_bag data bag can be accessed from all the methods of this class.
/**
 * @databag first_bag
 */
class HelloWorld extends \Jaxon\App\CallableClass
{
    // The second_bag data bag can be accessed only from this method.
    /**
     * @databag second_bag
     */
    public function doThat()
    {
        // Read data from or write data in data bags.
        $this->bag('first_bag')->set('first_value', $firstValue);
        $secondValue = $this->bag('second_bag')->get('second_value');

        return $this->response;
    }
}
```

#### L'upload de fichiers

The `@upload` annotation implements file upload in a method of a Jaxon class.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    // Calls to this method will upload the files in the HTML input field with id field_id.
    /**
     * @upload field_id
     */
    public function doThat()
    {
        // Get the uploaded files.
        $uploadedFiles = $this->files();

        return $this->response;
    }
}
```
