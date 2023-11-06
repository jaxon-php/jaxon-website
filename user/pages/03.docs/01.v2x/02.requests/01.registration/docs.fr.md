---
title: Enregistrer des objets et des fonctions PHP
menu: Déclarations
template: jaxon
---

Avant de pouvoir appeler une classe ou une fonction PHP avec javascript, celle-ci doit etre enregistrée, ou déclarée.
Pour cela on utilise la fonction `register()` de Jaxon.

#### Enregistrer une instance d'une classe

Pour enregistrer un objet, on appelle la fonction `register` avec le paramètre `Jaxon::CALLABLE_OBJECT`.

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

$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```

Après avoir été enregistré, les méthodes publiques de l'objet sont dans une classe javascript nommée `JaxonHelloWorld`.
Le préfixe `Jaxon` peut être changé à l'aide de l'option de configuration `core.prefix.class`.

Voici le code javascript généré par Jaxon.

```js
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

Voici un exemple de code HTML qui appelle des méthodes de la classe PHP exportée avec Jaxon.

```html
<input type="button" value="Say Hello" onclick="JaxonHelloWorld.sayHello(0)" />
<input type="button" value="Set Color" onclick="JaxonHelloWorld.setColor('red')" />
```

#### Enregistrer une fonction

Pour enregistrer une fonction, on appelle la fonction `register` avec le paramètre `Jaxon::USER_FUNCTION`.

```php
use Jaxon\Jaxon;
use Jaxon\Response\Response;

function hello_world($isCaps)
{
    $response = new Response();
    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div2', 'innerHTML', $text);
    return $response;
}

$jaxon->register(Jaxon::USER_FUNCTION, "hello_world");
```

Après avoir été enregistrée, cette fonction peut être appelée en javascript avec le nom `jaxon_hello_world()`.
Le préfixe `jaxon_` peut être changé à l'aide de l'option de configuration `core.prefix.function`.

Voici le code javascript généré par Jaxon, et envoyé dans le navigateur.

```js
jaxon_hello_world = function() {
    return jaxon.request(
        { jxnfun: 'helloWorld' },
        { parameters: arguments }
    );
};
```

Voici un exemple de code HTML qui appelle la fonction PHP enregistrée avec Jaxon.

```html
<input type="button" value="Submit" onclick="jaxon_hello_world()" />
```

Une méthode d'une classe peut aussi être enregistrée comme une fonction.
Pour cela, le deuxième paramètre de la fonction `register()` doit être un tableau, comme dans l'exemple suivant.

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
}

$hello = new HelloWorld;
$jaxon->register(Jaxon::USER_FUNCTION, array("hello_world", $hello, "sayHello"));
```

```html
<input type="button" value="Submit" onclick="jaxon_hello_world()" />
```

Si le tableau contient 2 éléments, la fonction javascript générée aura le même nom que la méthode.

```php
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, "sayHello"));
```

```html
<input type="button" value="Submit" onclick="jaxon_sayHello()" />
```

#### Définir les options des requêtes Jaxon

Des options supplémentaires peuvent être passées aux classes lors de leur enregistrement, et ajoutées aux appels en javascript.
Elles permettent de changer le comportement des requêtes Jaxon, sans changer la façon dont elles sont appelées.

En pratique, ces options sont ajoutées dans les fonctions javascript générées par Jaxon.

```php
// Options des classes
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld(), [
    'setColor' => [
        'name' => "'value'"
    ],
    '*' => [
        'name' => "'value'"
    ]
]);
// Options des fonctions
$jaxon->register(Jaxon::USER_FUNCTION, "hello_world", [
    'name' => "'value'"
]);
```

Les options sont définies dans un tableau dont les index sont sont leurs noms.
Notons que pour définir une option de type chaîne de caractères, les quotes sont inclues dans sa valeur.

Pour les classes, chaque groupe d'options est lui-même indexé par le nom de la méthode à laquelle elles s'appliquent, ou bien par `*` si les options s'appliquent à toutes les méthodes.

L'option `mode` par exemple permet de définir si les requêtes Jaxon sont asynchrones ou pas.

```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld(), [
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
