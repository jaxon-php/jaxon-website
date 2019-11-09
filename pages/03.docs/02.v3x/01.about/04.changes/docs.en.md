---
title: Migrating from version 2
menu: Migration from version 2
template: jaxon
---

The following features are impacted by changes from version 2:

- Registering functions, classes and directories
- The callbacks
- The request factory
- The pagination

If the application is using the `jaxon-armada` et `jaxon-sentry` packages, then the following features are also impacted.

- The CallableClass class
- The request processing

#### The registrations

Although the `register()` is still used to register functions and classes, its syntax and parameters have changes.

When registering a class, its name must now be provided, instead of an instance as in version 2.

With version 2
```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```

With version 3
```php
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```

The `register()` function must now be used to register directories.

With version 2
```php
$jaxon->addClassDir('/path/to/first/dir');
$jaxon->addClassDir('/path/to/second/dir', 'Name\\Space');
$jaxon->registerClasses();
```

With version 3
```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/path/to/first/dir');
$jaxon->register(Jaxon::CALLABLE_DIR, '/path/to/second/dir', ['namespace' => 'Name\\Space']);
```

A different syntax is used when registering a function.

With version 2
```php
$jaxon->register(Jaxon::USER_FUNCTION, 'sayHello');
```

With version 3
```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'sayHello');
```

The same apply when registering a class method as a function.

With version 2
```php
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, [$hello, 'sayHello']);
```

With version 3
```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'sayHello', ['class' => HelloWorld::class]);
```

The same apply when registering a function with an alias.

With version 2
```php
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, ['helloWorld', $hello, 'sayHello']);
```

With version 3
```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'sayHello', ['class' => HelloWorld::class, 'alias' => 'helloWorld']);
```

#### The callbacks

Jaxon provides a new api to define callbacks.

With version 2
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, 'functionName');

$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_AFTER, 'functionName');

$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, 'functionName');

$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_ERROR, 'functionName');
```

With version 3
```php
$jaxon->callback()->before(function($target, &$bEndRequest) {});

$jaxon->callback()->after(function($target, $bEndRequest) {});

$jaxon->callback()->invalid(function($sMessage) {});

$jaxon->callback()->error(function($xException) {});
```

The version 2 calls are deprecated in version 2, and will be removed in a future release.

#### The request factory

There are now two distinct global functions, `rq()` and `pr()`, that are respectively used to create requests to Jaxon classes and functions, and their parameters.

With version 2
```php
rq()->call('MyClass.showPage', rq()->select('colorselect'), rq()->page());
```

With version 3
```php
rq('MyClass')->call('showPage', pr()->select('colorselect'), pr()->page());
```

#### La pagination

There is a new syntax to use when generating pagination.

With version 2
```php
$pagination = rq()->paginate($count, $limit, $page, 'MyClass.showPage', rq()->select('colorselect'), rq()->page());
```

With version 3
```php
$pagination = rq('MyClass')->call('showPage', pr()->select('colorselect'), pr()->page())->paginate($page, $limit, $count);
```

#### The CallableClass class

In version 2, the advanced features (views, sessions, ...) are implemented in the `jaxon-armada` et `jaxon-sentry` packages.
These two packages are removed from version 3, and their features are now implemented in the `jaxon-core` package.

In order to inherit the advanced features, a Jaxon class must now extend the `Jaxon\CallableClass` class.

With version 2
```php
class HelloWorld extends \Jaxon\Sentry\Armada
{
    //
}
```

With version 3
```php
class HelloWorld extends \Jaxon\CallableClass
{
    //
}
```

The `instance()`, `request()` et `jQuery()` are removed in favor of their short versions `cl()`, `rq()` et `jq()`.

The pagination syntax has changed.

With version 2
```php
class HelloWorld extends \Jaxon\Sentry\Armada
{
    //
    public function showPage($pageNumber)
    {
        $pagination = $this->pg($itemsTotal, $itemsPerPage, $currentPage)->showPage(rq()->page());
    }
}
```

With version 3
```php
class HelloWorld extends \Jaxon\CallableClass
{
    //
    public function showPage($pageNumber)
    {
        $pagination = $this->rq()->showPage(pr()->page())->paginate($currentPage, $itemsPerPage, $itemsTotal);
    }
}
```

It should be noted that the order of parameters has also changed.

#### The bootstrapping

The `jaxon-armada` package allows to bootstrap the library from a single configuration file.
In the version 3, this feature is included in the `jaxon-core` package.

With version 2
```php
$armada = jaxon()->armada();
$armada->config('/path/to/config/file.php');
```

With version 3
```php
$app = jaxon()->app();
$app->setup('/path/to/config/file.php');
```

The configuration file syntax also has changed. See [this section](../../advanced/bootstrap) for more information.

#### The request processing

With the `jaxon-armada` package, when processing a Jaxon request, calling the `register()` method is not recommended, in order to avoid instantiating all the classes that have been registered.

In the version 3, this constraint is no more relevant, since the classes are no more instantiated when they are registered.

With version 2
```php
$armada = jaxon()->armada();
$armada->config('/path/to/config/file.php');

if($armada->canProcessRequest())
{
    // Process the request
    $armada->processRequest();
}
else
{
    // Register the classes
    $armada->register();
}
```

With version 3
```php
$app = jaxon()->app();

// Register classes from config file
$app->setup('/path/to/config/file.php');

if($app->canProcessRequest())
{
    // Process the request
    $app->processRequest();
}
```
