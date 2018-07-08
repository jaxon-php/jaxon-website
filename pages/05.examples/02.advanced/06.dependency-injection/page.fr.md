---
title: Injection de dépendance
menu: Injection de dépendance
template: jaxon
cache_enable: false
---

Cet exemple montre comment ajouter des dépendances dans le constructeur des classes Jaxon.

#### Comment ça marche

Définir les [services](/examples/codes/di-services.html), éventuellement avec les interfaces qu'elles implémentent.

Ajouter ces services en paramètres du constructeur des classes Jaxon, [comme dans cet exemple](/examples/codes/di-classes.html).

Lors de l'initialisation, on passera en paramètre à Jaxon le nom de la classe, et non une instance de la classe.
Définir ensuite l'injection de dépendances.
La librairie se chargera alors d'instancier la classe et toutes ses dépendances.

```php
// Register class name
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, HelloWorld::class);

// Bind the service interface with its implementation
$jaxon->di()->set(ExampleInterface::class, function($di){
    return new Example();
});

// Process the request, if any.
$jaxon->processRequest();
```

L'appel de la classe exportée dans le code Javascript ne change pas.

```php
<!-- Select -->
<select id="colorselect" onchange="<?php echo rq()->call('HelloWorld.setColor', rq()->select('colorselect')) ?>">
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>
<!-- Buttons -->
<button onclick="<?php echo rq()->call('HelloWorld.sayHello', 0) ?>">Click Me</button>
<button onclick="<?php echo rq()->call('HelloWorld.sayHello', 1) ?>">CLICK ME</button>
```
