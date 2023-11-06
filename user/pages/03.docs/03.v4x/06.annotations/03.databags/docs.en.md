---
title: Data bags
menu: Data bags
template: jaxon
---

The `@databag` annotation defines a [data bag](../../05.features/04.databags/) to be appended to ajax requests to a method.
It takes the name of the data bag as a mandatory parameter.
It applies to methods and classes.

```php
/**
 * @databag('name' => 'section')
 */
class JaxonExample
{
    /**
     * @databag('name' => 'user')
     */
    public function action()
    {
        // Read a value from the data bag.
        $count = $this->bag('user')->get('count', 0);
        // Update a value in the data bag.
        $this->bag('user')->set('count', $count++);
    }
}
```

The PHP-DOC syntax can also be used.

```php
/**
 * @databag section
 */
class JaxonExample
{
    /**
     * @databag user
     */
    public function action()
    {
        // Read a value from the data bag.
        $count = $this->bag('user')->get('count', 0);
        // Update a value in the data bag.
        $this->bag('section')->set('count', $count++);
    }
}
```
