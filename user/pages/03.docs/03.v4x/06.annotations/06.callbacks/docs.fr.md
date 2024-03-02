---
title: Callbacks Javascript
menu: Callbacks Js
template: jaxon
---

L'annotation `@callback` définit une [callback javascript](../../requests/js-callbacks/), qui est un objet javascript qui définit des fonctions à appeler à différentes étapes du traitement d'une requête Ajax.

```php
/**
 * @callback('name' => 'app.callback.example')
 */
class JaxonExample
{
    /**
     * @callback('name' => 'app.callback.example')
     */
    public function action()
    {
    }
}
```

La syntaxe PHP-DOC peut également être utilisée.

```php
/**
 * @callback app.callback.example
 */
class JaxonExample
{
    /**
     * @callback app.callback.example
     */
    public function action()
    {
    }
}
```
