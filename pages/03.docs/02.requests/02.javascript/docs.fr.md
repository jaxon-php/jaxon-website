---
title: Générer le code javascript
menu: Le code javascript
template: jaxon
---

Une fois que les fonctions et les objets PHP ont été exportés, l'étape suivante consiste à générer le code à insérer dans les pages HTML.
Jaxon fournit 3 fonctions différentes pour générer le code à envoyer au navigateur.

- La fonction `$jaxon->getCss()` renvoie le code CSS à insérer dans la page. Il s'agira très souvent des instructions de chargement des fichiers CSS des plugins Jaxon.
- La fonction `$jaxon->getJs()` le code de chargement des fichiers javascript externes.
- La fonction `$jaxon->getScript()` renvoie le code javascript correspondant aux fonctions et classes exportées, et à la configuration de la librairie.

La séparation en 3 fonctions distinctes permet d'afficher les codes générés par la librairie Jaxon dans des parties différentes de la page HTML.  
L'appel `$jaxon->getScript(true, true)` renvoie la sortie cumulée des 3 appels précédents.

#### Les appels Javascript

Lorsqu'une fonction PHP est exportée avec Jaxon, le nom de la fonction javascript générée est celui de la fonction PHP préfixée de la valeur de l'option de configuration `core.prefix.function`. La valeur par défaut de ce paramètre est `jaxon_`.

```php
$jaxon->register(Jaxon::USER_FUNCTION, 'helloWorld');
```
```javascript
<button onclick="jaxon_helloWorld(0)">Click Me</button>
```

Lorsqu'une classe PHP est exportée avec Jaxon, le nom de la classe javascript générée est celui de la fonction PHP préfixée de la valeur de l'option de configuration `core.prefix.class`. La valeur par défaut de ce paramètre est `Jaxon`.

```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```
```javascript
<button onclick="JaxonHelloWorld.sayHello(0)">Click Me</button>
```

#### Les paramètres des appels javascript

La librairie javascript de Jaxon permet de passer des éléments du contenu de la page web en paramètres des appels Ajax.

La fonction `jaxon.getFormValues(id)` lit le contenu du formulaire dont l'id est indiqué.

L'exemple suivant transmet le contenu du formulaire à une fonction Jaxon.
```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.getFormValues('DemoForm'))">Click Me</button>
````

La fonction `jaxon.$(id)` lit le contenu de l'élément dont l'id est indiqué.

L'exemple suivant transmet la valeur d'une zone de texte ou d'une liste déroulante à une fonction Jaxon.
```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.$('DemoData').value)">Click Me</button>
````

L'exemple suivant transmet la valeur d'une case à cocher à une fonction Jaxon.
```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.$('DemoData').checked)">Click Me</button>
````

L'exemple suivant transmet le contenu d'un élément de la page à une fonction Jaxon.
```php
<button onclick="JaxonHelloWorld.sayHello(jaxon.$('DemoDiv').innerHTML)">Click Me</button>
````

La [Fabrique de requêtes](/docs/requests/factory) permet de générer les appels javascript ci-dessus à partir de PHP.
```php
use Jaxon\Request\Factory as jr;

<button onclick="<?php echo jr::call('HelloWorld.sayHello', jr::html('DemoDiv')) ?>">Click Me</button>
````
