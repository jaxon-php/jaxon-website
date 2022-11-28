---
title: Les hooks
menu: Les hooks
template: jaxon
---

Les annotations `@before` et `@after` permettent d'appeler des méthodes d'une classe avant ou après la méthode de la requête Ajax.

Elles peuvent être définies sur les classes et les méthodes publiques, et elles peuvent être repétées.

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
        // La fonction funcBefore() sera appelée avant celle-ci.
        // Les fonctions funcAfter() et funcAfter2() seront appelées après celle-ci.
    }
}
```
