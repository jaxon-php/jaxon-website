---
title: Exclude methods
menu: Exclude methods
template: jaxon
---

The `@exclude` annotation prevents a method or a class from being exported to javascript.
It takes an optional boolean parameter.

```php
// This class will not be exported to javascript.
/**
 * @exclude(true)
 */
class JaxonExample
{
}
```

```php
class JaxonExample
{
    /**
     * @exclude
     */
    public function doNot()
    {
        // This method will not be exported to javascript.
    }
}
```

The PHP-DOC syntax can also be used.

```php
class JaxonExample
{
    /**
     * @exclude false
     */
    public function do()
    {
        // This method will be exported to javascript.
    }

    /**
     * @exclude true
     */
    public function doNot()
    {
        // This method will not be exported to javascript.
    }
}
```
