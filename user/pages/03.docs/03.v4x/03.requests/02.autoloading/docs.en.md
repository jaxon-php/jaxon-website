---
title: Autoloading
menu: Autoloading
template: jaxon
---

When the Jaxon library processes a request to a given class, it has to create an instance of this class in order to call the target method.
Jaxon must therefore be able to find all the classes that have been registered.

For the developer who wants it, the Jaxon library can handle autoloading for all the classes it calls.

#### Autoloading a class

When registering a class, the `include` option allows to specify the path to the file where the class is defined.

```php
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, ['include' => '/path/to/dir/HelloWorld.php']);
```

This file will be included in the application only if a method of the class is called.

#### Autoloading a directory

When registering a directory without a namespace, the `autoload` option can be use to setup autoloading.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['autoload' => true]);
```

In this case, Jaxon will browse the directory and register each class found with the corresponding file, using the `include` option.

#### Autoloading a namespace

When registering a directory with a namespace, the `autoload` option can also be use to setup autoloading.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['namespace' => 'App\Jaxon', 'autoload' => true]);
```

In this case, Jaxon will add the directory to the Composer autoloading mechanism.
