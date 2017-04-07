---
title: La fabrique de requête
menu: Fabrique de requête
template: jaxon
---

La classe `Jaxon\Request\Factory` permet de créer des requêtes vers les fonctions ou les méthodes exportées avec Jaxon.
Elle implémente une fonction `call()` pour créer la requête, et un ensemble d'autres fonctions pour lui passer des éléments du contenu de la page HTML en paramètre.

Par exemple, le code suivant utilise la fabrique de requête pour générer l'appel vers une classe Jaxon, en lui passant la valeur de la liste déroulante qui a l'id `colorselect`.

```php
<?php
use Jaxon\Jaxon;
use Jaxon\Request\Factory as rq;

class MyClass
{
    public function myMethod($color)
    {
        // Function body
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::CALLABLE_OBJECT, $myObject);
?>
<script type='text/javascript'>
    /* <![CDATA[ */
    window.onload = function() {
        /* call the MyClass->myMethod() method on load */
        <?php echo rq::call('MyClass.myMethod', rq::select('colorselect')) ?>;
    }
    /* ]]> */
</script>
```

Le code javascript suivant sera alors généré.

```html
<script type='text/javascript'>
    /* <![CDATA[ */
    window.onload = function() {
        // call the MyClass->myMethod() method on load
        JaxonMyClass.myMethod(jaxon.$('colorselect').value);
    }
    /* ]]> */
</script>
```

La liste complète des fonctions de la classe `Jaxon\Request\Factory` est [documentée ici](/api/Jaxon/Request/Factory.html).

#### Le trait de la fabrique de requête

Le trait `Jaxon\Request\Traits\Factory` ajoute aux classes Jaxon une fonction `call()` qui simplifie la création des requêtes Jaxon vers leurs méthodes. Elle prend en paramètre le nom d'une méthode, et lui ajoute automatiquement le nom de la classe en javascript.

```php
<?php
use Jaxon\Request\Factory as rq;

class MyClass
{
    use \Jaxon\Request\Traits\Factory;

    public function myMethod($color)
    {
        // Requête Jaxon vers cette méthode
        $request = $this->call('myMethod', rq::select('colorselect'));
        $btn = '<button class="button radius" onclick="' . $request . '" >Click Me</button>'
    }
}
```
