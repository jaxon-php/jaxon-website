---
title: Enregistrer des classes PHP
menu: Enregistrer des classes
template: jaxon
---

Avant de pouvoir appeler une classe ou une fonction PHP avec javascript, celle-ci doit etre enregistrée, ou déclarée.
Pour cela on utilise la fonction `register()` de Jaxon.

Pour enregistrer une classe, on appelle la fonction `register()` avec le paramètre `Jaxon::CALLABLE_CLASS`.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;

class HelloWorld
{
    public function sayHello($isCaps)
    {
        $response = new Response();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
        return $response;
    }

    public function setColor($sColor)
    {
        $response = new Response();
        $response->assign('div2', 'style.color', $sColor);
        return $response;
    }
}
```

```php
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```

Après avoir été enregistré, les méthodes publiques de la classe sont dans une classe javascript nommée `JaxonHelloWorld`.
Le préfixe `Jaxon` est défini à l'aide de l'option de configuration `core.prefix.class`.

Voici le code javascript généré par Jaxon.

```javascript
JaxonHelloWorld = {};
JaxonHelloWorld.sayHello = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'sayHello' },
        { parameters: arguments }
    );
};
JaxonHelloWorld.setColor = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'setColor' },
        { parameters: arguments }
    );
};
```

Voici un exemple de code HTML qui appelle cette classe.

```html
<input type="button" value="Say Hello" onclick="JaxonHelloWorld.sayHello(0)" />
<input type="button" value="Set Color" onclick="JaxonHelloWorld.setColor('red')" />
```

#### Définir les options des requêtes Jaxon

Des options supplémentaires peuvent être passées aux classes lors de leur enregistrement, et ajoutées aux appels en javascript.
Elles permettent de changer le comportement des requêtes Jaxon, sans changer la façon dont elles sont appelées.

En pratique, ces options sont ajoutées dans les fonctions javascript générées par Jaxon.

```php
// Options des classes
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, [
    'setColor' => [
        'name' => "'value'"
    ],
    '*' => [
        'name' => "'value'"
    ]
]);
// Options des fonctions
$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world", [
    'name' => "'value'"
]);
```

Les options sont définies dans un tableau dont les index sont sont leurs noms.
Notons que pour définir une option de type chaîne de caractères, les quotes sont inclues dans sa valeur.

Pour les classes, chaque groupe d'options est lui-même indexé par le nom de la méthode à laquelle elles s'appliquent, ou bien par `*` si les options s'appliquent à toutes les méthodes.

L'option `mode` par exemple permet de définir si les requêtes Jaxon sont asynchrones ou pas.

```php
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, [
    'setColor' => [
        'mode' => "'synchronous'"
    ],
    '*' => [
        'mode' => "'asynchronous'"
    ]
]);
```

Le code javascript généré est le suivant.

```js
JaxonHelloWorld.sayHello = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'sayHello' },
        { parameters: arguments, mode: 'asynchronous' }
    );
};
JaxonHelloWorld.setColor = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'setColor' },
        { parameters: arguments, mode: 'synchronous' }
    );
};
```
