---
title: Exporter des fonctions
menu: Exporter des fonctions
template: jaxon
---

Pour exporter une fonction, la syntaxe est la suivante:
```php
function my_function()
{
    // Function body
}

$jaxon->register(Jaxon::USER_FUNCTION, "my_function");
```
Après avoir été exportée, cette fonction peut être appelée en javascript avec le nom `jaxon_my_function()`.
Le préfixe `jaxon_` peut être changé à l'aide de l'option de configuration `core.prefix.function`.

Voici un exemple de code HTML qui appelle la fonction PHP exportée avec Jaxon.
```html
<input type="button" value="Submit" onclick="jaxon_my_function()" />
```

Une méthode d'une classe peut aussi être exportée comme une fonction. Pour cela, le deuxième paramètre de la fonction `register()` doit être un tableau, comme dans l'exemple suivant.
```php
class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::USER_FUNCTION, array("my_function", $myObject, "myMethod"));
```

Si le tableau contient 2 éléments, la fonction javascript générée aura le même nom que la méthode.
```php
$jaxon->register(Jaxon::USER_FUNCTION, array($myObject, "myMethod"));
```
