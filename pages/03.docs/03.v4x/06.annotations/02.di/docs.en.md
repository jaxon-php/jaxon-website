---
title: Dependency injection
menu: Dependency injection
template: jaxon
---

The `@di` annotation defines objects that are injected in Jaxon classes.

It can be defined on a class, on public or protected attribues, or on methods.
It can be repeated.

On a class or a method, this annotation takes the attribute name and type as parameters.
Remember that this type must be declared with the [dependency injection](../04.dependency-injection/).
```php
/**
 * @di('attr' => 'translator', class => '\App\Services\Translator') 
 * @di $translator \App\Services\Translator
 */
```

If the attribute is already declared with a type, it can then be omitted in the annotation.
```php
/**
 * @var \App\Services\Translator
 */
protected $translator;

/**
 * @di('attr' => 'translator') 
 * @di $translator
 */
```

On an attrbute, the annotation name must be omitted.
```php
use App\Services\Translator;

/**
 * @di Translator
 */
protected $translator;
```

If the attribute type is already declared, it can also be omitted.
```php
use App\Services\Translator;

/**
 * @di
 * @var Translator
 */
protected $translator;
```
