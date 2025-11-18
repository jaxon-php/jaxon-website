---
title: Annotations
menu: Annotations
template: jaxon
---

Annotations are an optional feature provided in the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package.

They are however recommended, since they highly simplify the implementation of other features, by allowing to define their configuration parameters in the same files as the Jaxon classes, rather than in the configuration file.

In order to use them, the [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations) package must be installed, and the `core.annotations.enabled` option must be set to the boolean value `true`.

#### Annotation syntax

The annotations for Jaxon classes use the `docblock` syntax, and can be added to the class, to its properties or to its methods.

```php
/**
 * @databag bag_name
 */
class HelloWorld
{
    /**
     * @di
     * @var \App\Services\Translator
     */
    protected $translator;

    /**
     * @upload field_id
     */
    public function doThat()
    {
    }
}
```

The annotations parameters accept two types of syntax.

With the `PHP-DOC` syntax, the parameters follow the annotation name.

```php
class HelloWorld
{
    /**
     * @databag bag_name
     */
    public function doThat()
    {
    }
}
```

The parameters can also be enclosed in parentheses, with a syntax that is similar to arrays in PHP.
In this case, they can also be named.

```php
class HelloWorld
{
    /**
     * @databag('name' => 'bag_name')
     */
    public function doThat()
    {
    }
}
```

#### Available annotations

In the 2.1 version, 6 annotations instructions are provided.

- `@di`: for [dependency injection](../../05.features/03.dependency-injection/)
- `@databag`: for [data bags](../../05.features/04.databags/)
- `@upload`: for [file upload](../../05.features/06.upload/)
- `@before`: for [callbacks](../../05.features/05.hooks/) to call before the requested method
- `@after`: for [callbacks](../../05.features/05.hooks/) to call bafter the requested method
- `@exclude`: to exclude classes or public methods from the generated Javascript code
