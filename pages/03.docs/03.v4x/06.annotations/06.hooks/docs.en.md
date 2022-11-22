---
title: Hooks
menu: Hooks
template: jaxon
---

The `@before` and `@after` annotations allow to call a method before or after the method of the ajax request.

They can be declared on classes and public methods, and they can be repeated.

```php
/**
 * @before('call' => 'funcBefore')
 * @after('call' => 'funcAfter')
 */
class ClassAnnotated extends CallableClass
{
    protected function funcBefore()
    {
        //
    }

    protected function funcAfter()
    {
        //
    }

    protected function funcAfter2()
    {
        //
    }

    /**
     * @after funcAfter2
     */
    public function doSomething()
    {
        // The funcBefore() method will be called before this one.
        // The funcAfter() and funcAfter2() methods will be called after this one.
    }
}
```
