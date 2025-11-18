---
title: Javascript Callbacks
menu: Js Callbacks
template: jaxon
---

The `@callback` annotation defines a [javascript callback](../../requests/js-callbacks/), which is a javascript object providing functions to be called at different stages of the Ajax request processing.

```php
/**
 * @callback('name' => 'section')
 */
class JaxonExample
{
    /**
     * @callback('name' => 'user')
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
 * @callback section
 */
class JaxonExample
{
    /**
     * @callback user
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
