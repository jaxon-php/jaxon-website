---
title: Hooks
menu: Hooks
template: jaxon
---

L'annotation `@before` définit une méthode d'une classe comme un [hook à appeler](../../05.features/05.hooks/) avant le traitement d'une requête.
Elle prend le nom de la méthode en paramètre obligatoire, et en option un tableau de paramètre à passer au hook.
Elle s'applique aux méthodes et aux classes.

```php
class JaxonExample
{
    protected function funcBefore1()
    {
        // Do something
    }

    protected function funcBefore2($param1, $param2)
    {
        // Do something with parameters
    }

    /**
     * @before('call' => 'funcBefore1')
     * @before('call' => 'funcBefore2', 'with' => ['value1', 'value2'])
     */
    public function action()
    {
    }
}
```

The PHP-DOC syntax can also be used.

```php
class JaxonExample
{
    protected function funcBefore1()
    {
        // Do something
    }

    protected function funcBefore2($param1, $param2)
    {
        // Do something with parameters
    }

    /**
     * @before funcBefore1
     * @before funcBefore2 ["value1", "value2"]
     */
    public function action()
    {
    }
}
```

L'annotation `@after` définit une méthode d'une classe comme un [hook à appeler](../../05.features/05.hooks/) après le traitement d'une requête.
Elle prend le nom de la méthode en paramètre obligatoire, et en option un tableau de paramètre à passer au hook.
Elle s'applique aux méthodes et aux classes.

```php
class JaxonExample
{
    protected function funcAfter1()
    {
        // Do something
    }

    protected function funcAfter2($param)
    {
        // Do something with parameter
    }

    /**
     * @after('call' => 'funcAfter1')
     * @after('call' => 'funcAfter2', 'with' => ['value'])
     */
    public function action()
    {
    }
}
```

The PHP-DOC syntax can also be used.

```php
class JaxonExample
{
    protected function funcAfter1()
    {
        // Do something
    }

    protected function funcAfter2($param)
    {
        // Do something with parameter
    }

    /**
     * @after funcAfter1
     * @after funcAfter2 ["value"]
     */
    public function action()
    {
    }
}
```
