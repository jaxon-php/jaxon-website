---
title: Exporter des objets
menu: Exporter des objets
template: jaxon
---

Pour exporter un objet, la syntaxe est la suivante:
```php
class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}

$myObject = new MyClass;
$jaxon->register(Jaxon::CALLABLE_OBJECT, $myObject);
```

Après avoir été exportées, toutes les méthodes publiques de l'objet sont présentes en javascript dans une classe nommée `JaxonMyClass`.
Le préfixe `Jaxon` peut être changé à l'aide de l'option de configuration `core.prefix.class`.

Voici un exemple de code HTML qui appelle une méthode de la classe PHP exportée avec Jaxon.
```html
<input type="button" value="Submit" onclick="JaxonMyClass.myMethod()" />
```
