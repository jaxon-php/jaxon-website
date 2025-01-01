---
title: Enregistrer des fonctions PHP
menu: Fonctions
template: jaxon
---

La section `app.functions` de la configuration contient un tableau de fonctions à exporter.

En voici un exemple.

```php
function hello_world($isCaps)
{
    $response = jaxon()->newResponse();
    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div2', 'innerHTML', $text);
}
```

```php
    'app' => [
        'functions' => [
            'hello_world',
            'sayhello',
        ],
    ],
```

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world");
```

Après avoir été enregistrée, cette fonction peut être appelée en javascript avec le nom `hello_world()`.

Voici le code javascript généré par Jaxon, et envoyé dans le navigateur.

```js
hello_world = function() {
    return jaxon.request(
        { jxnfun: 'helloWorld' }, { parameters: arguments }
    );
};
```

Le nom de la fonction javascript peut être changé avec un alias.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["alias" => "sayHello"]);
```

Des options peuvent être ajoutées aux fonctions.

```php
    'app' => [
        'functions' => [
            'hello_world' => [
                'mode' => "'asynchronous'",
            ],
        ],
    ],
```

Une méthode d'une classe peut aussi être enregistrée comme une fonction.
Pour cela, le nom de la classe doit être passé à la fonction `register()`, comme dans l'exemple suivant.

```php
use function Jaxon\jaxon;

class HelloWorld
{
    public function hello_world($isCaps)
    {
        $response = jaxon()->newResponse();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
    }
}
```

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class]);
```

De même, un alias peut être défini.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

jaxon()->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class, "alias" => "sayHello"]);
```
