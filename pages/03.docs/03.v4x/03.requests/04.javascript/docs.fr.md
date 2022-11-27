---
title: Appeler le code javascript
menu: Les appels javascript
template: jaxon
---

Lorsqu'une fonction PHP est enregistrée avec Jaxon, le nom de la fonction javascript générée est celui de la fonction PHP préfixée de la valeur de l'option de configuration `core.prefix.function`. La valeur par défaut de ce paramètre est `jaxon_`.

```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'helloWorld');
```
```javascript
<button onclick="jaxon_helloWorld(0)">Click Me</button>
```

Lorsqu'une classe PHP est enregistrée avec Jaxon, le nom de la classe javascript générée est celui de la fonction PHP préfixée de la valeur de l'option de configuration `core.prefix.class`. La valeur par défaut de ce paramètre est `Jaxon`.

```php
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```

```javascript
<button onclick="JaxonHelloWorld.sayHello(0)">Click Me</button>
```

#### Les paramètres des appels javascript

Des paramètres de différents types peuvent être passés aux fonctions javascript générées par Jaxon : entier, booléen, caractères, tableaux ou objets.
Ils sont automatiquement passés aux classes PHP correspondantes.

La librairie javascript de Jaxon permet de passer des éléments du contenu de la page web en paramètres des appels Ajax.

La fonction `jaxon.getFormValues(id)` lit le contenu du formulaire dont l'id est indiqué.

L'exemple suivant transmet le contenu du formulaire à une fonction Jaxon.

```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.getFormValues('DemoForm'))">Click Me</button>
```

La fonction `jaxon.$(id)` lit le contenu de l'élément dont l'id est indiqué.

L'exemple suivant transmet la valeur d'une zone de texte ou d'une liste déroulante à une fonction Jaxon.
```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.$('DemoData').value)">Click Me</button>
```

L'exemple suivant transmet la valeur d'une case à cocher à une fonction Jaxon.
```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.$('DemoData').checked)">Click Me</button>
```

L'exemple suivant transmet le contenu d'un élément de la page à une fonction Jaxon.
```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.$('DemoDiv').innerHTML)">Click Me</button>
```

La [Fabrique de requêtes](../factory) permet de générer les appels javascript ci-dessus, ainsi que leurs paramètres, à partir de PHP.
