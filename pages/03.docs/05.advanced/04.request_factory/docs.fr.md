---
title: La fabrique de requête
menu: La fabrique de requête
template: jaxon
---

La classe `Jaxon\Request\Factory` permet de créer des requêtes vers les fonctions ou les méthodes exportées avec Jaxon.
Elle implémente une fonction `call()` pour créer la requête, et un ensemble d'autres fonctions pour lui passer des éléments de contenu de la page HTML en paramètre.

Par exemple, le code suivant utilise la Request Factory pour générer l'appel vers une classe Jaxon.

```php
<?php
use Jaxon\Request\Factory as jr;

class MyClass
{
    public function myMethod($myString)
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
        <?php echo jr::call('MyClass.myMethod', jr::select('colorselect')) ?>;
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
        MyClass.myMethod(jaxon.$('colorselect').value);
    }
    /* ]]> */
</script>
```

La liste complète des fonctions de la classe `Jaxon\Request\Factory` est [documentée ici](http://www.jaxon-php.org/docs/api/class-Jaxon.Request.Factory.html).

Le trait `Jaxon\Request\FactoryTrait` ajoute aux classes Jaxon une fonction `call()` qui simplifie la création des requêtes Jaxon vers leurs méthodes. Elle prend en paramètre le nom d'une méthode, et lui ajoute automatiquement le nom de la classe en javascript.
```php
<?php
use Jaxon\Request\Factory as jr;

class MyClass
{
    use \Jaxon\Request\FactoryTrait;

    public function myMethod($myString)
    {
        // Requête Jaxon vers cette méthode
        $request = $this->call('myMethod', jr::select('colorselect'));
        $btn = '<button class="button radius" onclick="' . $request . '" >Click Me</button>'
    }
}
```
