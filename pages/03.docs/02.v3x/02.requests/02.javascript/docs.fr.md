---
title: Générer et appeler le code javascript
menu: Les appels javascript
template: jaxon
---

Une fois que les classes PHP ont été enregistrées, l'étape suivante consiste à générer le code javascript correspondant.
Jaxon fournit 3 fonctions différentes pour cela.

- La fonction `$jaxon->getCss()` renvoie le code CSS à insérer dans la page. Il s'agira très souvent des instructions de chargement des fichiers CSS des plugins Jaxon.
- La fonction `$jaxon->getJs()` le code de chargement des fichiers javascript externes.
- La fonction `$jaxon->getScript()` renvoie le code javascript correspondant aux fonctions et classes enregistrées, et à la configuration de la librairie.

La séparation en 3 fonctions distinctes permet d'afficher les codes générés par la librairie Jaxon dans des parties différentes de la page HTML.
L'appel `$jaxon->getScript(true, true)` renvoie la sortie cumulée des 3 appels précédents.

#### Le code Javascript

Lorsque l'option `js.app.extern` a la valeur `false`, la fonction `$jaxon->getScript()` renvoie le code javascript, qui sera donc directement inclus dans le code HTML de la page.

Si cette option a la valeur `true`, le code javascript est enregistré dans un fichier dans le répertoire indiqué par l'option `js.app.dir`,
et la fonction `$jaxon->getScript()` renvoie le code HTML pour charger ce fichier à partir de l'URL indiquée par l'option `js.app.uri`.
Si en plus l'option `js.app.minify` a la valeur `true`, le code javascript est minifié et le nom du fichier se termine par `.min.js`.

Le fichier javascript n'est plus généré s'il existe déjà.
Il est donc conseillé de mettre l'option `js.app.extern` à `false` pendant le développement, et de générer un fichier minifié lorsque l'application est déployée.

#### Les appels Javascript

Lorsqu'une fonction PHP est enregistrée avec Jaxon, le nom de la fonction javascript générée est celui de la fonction PHP préfixée de la valeur de l'option de configuration `core.prefix.function`. La valeur par défaut de ce paramètre est `jaxon_`.

Lorsqu'une classe PHP est enregistrée avec Jaxon, le nom de la classe javascript générée est celui de la fonction PHP préfixée de la valeur de l'option de configuration `core.prefix.class`. La valeur par défaut de ce paramètre est `Jaxon`.

```php
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```
```javascript
<button onclick="JaxonHelloWorld.sayHello(0)">Click Me</button>
```

```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'helloWorld');
```
```javascript
<button onclick="jaxon_helloWorld(0)">Click Me</button>
```

#### Les paramètres des appels javascript

Des paramètres de tout type peuvent être passés aux fonctions javascript générées par Jaxon : entier, booléen, caractères, tableaux ou objets.
Ils sont automatiquement passés aux classes PHP correspondantes.

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

La [Fabrique de requêtes](/docs/requests/factory) permet de générer les appels javascript ci-dessus, ainsi que leurs paramètres, à partir de PHP.
