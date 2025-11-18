---
title: Enregistrer des répertoires
menu: Répertoires
template: jaxon
---

Une application PHP moyenne peut contenir des dizaines, voire des centaines de classes. Enregistrer individuellement chaque classe avec Jaxon peut être fastidieux et générer des erreurs, en plus de produire un code verbeux.

Les classes d'une application PHP vont généralement être réparties dans plusieurs répertoires, chacun pouvant être associé à un namespace.
La librairie Jaxon permet alors d'enregistrer en une fois toutes les classes présentes dans un répertoire.

Si on prend un répertoire `/the/class/dir` qui contient les classes suivantes.

Dans le fichier `/the/class/dir/App/FirstClass.php`

```php
class FirstClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

Dans le fichier `/the/class/dir/App/SecondClass.php`

```php
class SecondClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

Ces classes sont enregistrées avec Jaxon ainsi.

```php
$jaxon = jaxon();
$jaxon->addClassDir('/the/class/dir');
$jaxon->registerClasses();
```

Pour déterminer le nom de la classe javascript à créer, Jaxon introduit la notion de `classpath`.  
Pour une classe enregistrée dans un répertoire donné, le `classpath` est le chemin depuis ce répertoire jusqu'au sous-répertoire qui contient la classe, avec les `/` et les `\` remplacés par des `.`.  
Le `classpath` est préfixé au nom de la classe PHP pour donner le nom de la classe javascript correspondante.

Dans l'exemple ci-dessus, les noms des classes javascript seront `App.FirstClass` et `App.SecondClass`.

Voici le code javascript généré par Jaxon.

```js
App = {};
App.FirstClass = {};
App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'App.FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
App.SecondClass = {};
App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'App.SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments }
    );
};
```

#### Définir les options des requêtes Jaxon

Des options supplémentaires peuvent être passées aux classes lors de leur enregistrement, et ajoutées aux appels en javascript.
Pour cela, il faut passer à l'appel à `$jaxon->registerClasses()` un tableau dont chaque entrée définit les options d'une classe.

Les entrées sont indexées par le nom des classes javascript, qui dans ce cas est le nom de la classe PHP correspondante préfixée de son `classpath`.

```php
$jaxon->registerClasses([
    'App.FirstClass' => [
        '*' => [
            'mode' => "'asynchronous'"
        ]
    ],
    'App.SecondClass' => [
        '*' => [
            'mode' => "'synchronous'"
        ]
    ]
]);
```

Voici le code javascript généré par Jaxon.

```js
App = {};
App.FirstClass = {};
App.FirstClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'App.FirstClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'asynchronous' }
    );
};
App.SecondClass = {};
App.SecondClass.myMethod = function() {
    return jaxon.request(
        { jxncls: 'App.SecondClass', jxnmthd: 'myMethod' },
        { parameters: arguments, mode: 'synchronous' }
    );
};
```
