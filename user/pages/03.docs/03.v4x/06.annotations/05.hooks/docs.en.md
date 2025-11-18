---
title: Hooks
menu: Hooks
template: jaxon
---

The `@before` annotation defines a method of the class as a [hook to be called](../../05.features/05.hooks/) before processing the request.
It takes the name of the method as a mandatory parameter, and an array as optional parameters to be passed to the hook.
It applies to methods and classes.

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

La syntaxe PHP-DOC peut également être utilisée.

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

The `@after` annotation defines a method of the class as a [hook to be called](../../05.features/05.hooks/) after processing the request.
It takes the name of the method as a mandatory parameter, and an array as optional parameters to be passed to the hook.
It applies to methods and classes.

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
