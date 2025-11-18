---
title: Enregistrer des fonctions PHP
menu: Fonctions
template: jaxon
---

Avant de pouvoir appeler une classe ou une fonction PHP avec javascript, celle-ci doit etre enregistrée, ou déclarée.
Pour cela on utilise la fonction `register()` de Jaxon.

Pour enregistrer une fonction, on appelle la fonction `register` avec le paramètre `Jaxon::CALLABLE_FUNCTION`.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

function hello_world($isCaps)
{
    $response = jaxon()->newResponse();
    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div2', 'innerHTML', $text);
    return $response;
}

$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world");
```

Après avoir été enregistrée, cette fonction peut être appelée en javascript avec le nom `jaxon_hello_world()`.
Le préfixe `jaxon_` est défini à l'aide de l'option de configuration `core.prefix.function`.

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

Le nom de la fonction javascript peut être changé avec un alias.

```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["alias" => "sayHello"]);
```

```html
<input type="button" value="Say Hello" onclick="jaxon_sayHello(0)" />
```

Une méthode d'une classe peut aussi être enregistrée comme une fonction.
Pour cela, le nom de la classe doit être passé à la fonction `register()`, comme dans l'exemple suivant.

```php
use Jaxon\Jaxon;
use function Jaxon\jaxon;

class HelloWorld
{
    public function hello_world($isCaps)
    {
        $response = jaxon()->newResponse();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
        return $response;
    }
}

$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class]);
```

```html
<input type="button" value="Submit" onclick="jaxon_hello_world()" />
```

De même, un alias peut être défini.

```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world", ["class" => HelloWorld::class, "alias" => "sayHello"]);
```

```html
<input type="button" value="Submit" onclick="jaxon_sayHello()" />
```
