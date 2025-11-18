---
title: Exclure des méthodes
menu: Exclure des méthodes
template: jaxon
---

L'annotation `@exclude` empêche une méthode ou une classe d'être exportée en javascript.
Elle prend un paramètre booléen optionnel.

```php
// Cette classe ne sera pas exportée en javascript.
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
        // Cette méthode ne sera pas exportée en javascript.
    }
}
```

La syntaxe PHP-DOC peut également être utilisée.

```php
class JaxonExample
{
    /**
     * @exclude false
     */
    public function do()
    {
        // Cette méthode sera exportée en javascript.
    }

    /**
     * @exclude true
     */
    public function doNot()
    {
        // Cette méthode ne sera pas exportée en javascript.
    }
}
```
