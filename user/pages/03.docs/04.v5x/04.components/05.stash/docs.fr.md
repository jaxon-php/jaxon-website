---
title: Le data stash
menu: Le data stash
template: jaxon
---

Le `data stash` est un objet qui sert à stocker des données pendant le traitement d'une requête, et dont la durée de vie est donc limitée au traitement de la requête.

Les données stockées dans le `data stash` seront accessibles par tous les composants instantiés pendant le traitement d'une requête.
Il permet donc de partager des données entre différents composants.

#### Usage

Toutes les classes de composants de Jaxon possèdent une fonction `stash()` qui renvoie le même objet `data stash`.
Cet objet possède deux fonctions `set()` et `get()` qui permettent respectivement de définir ou lire une valeur dans le `stash`.

```php
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function save()
    {
        $this->stash()->set('value_key', $value);
    }

    public function read()
    {
        $value = $this->stash()->get('value_key');
    }
}
```

Le deuxième paramètre de la fonction `set()` peut être soit la valeur à stocker, soit une callback qui retourne cette valeur.
Si on lui passe une callback, elle sera appelée la première fois que la valeur est lue.

Combinée aux `data bags`, le `data stash` mettent en oeuvre l'équivalent d'un état de l'application, mais dont le contenu dépendra du composant appelé par la requête Jaxon.

```php
/**
 * @databag bag_key
 * @before init
 */
class FirstClass extends \Jaxon\App\FuncComponent
{
    protected function init()
    {
        // Save the object in the stash
        $this->stash()->set('object_id', function() {
            $id = $this->bag('bag_key')->get('object_id');
            // Find and return the object
            // ...
        });
    }

    public function read()
    {
        // Get the object from the stash
        $object = $this->stash()->get('object_id');
        // ...

        // Call a method in another class
        $this->cl(SecondClass::class)->doThat();
    }
}
```

```php
class SecondClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        // Get the object from the stash
        $object = $this->stash()->get('object_id');
        // ...
    }
}
```

L'annotation `@before` définit une méthode à appeler avant celle ciblée par la requête ajax.
