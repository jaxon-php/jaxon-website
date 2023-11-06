---
title: Les data bags
menu: Les data bags
template: jaxon
---

L'annotation `@databag` définit un [data bag](../../05.features/04.databags/) à embarquer dans les requêtes ajax vers une méthode.
Elle prend le nom du data bag comme paramètre obligatoire.
Elle s'applique aux méthodes et aux classes.

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
        $this->bag('section')->set('count', $count++);
    }
}
```

La syntaxe PHP-DOC peut également être utilisée.

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
