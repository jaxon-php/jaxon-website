---
title: Exporter des fonctions
menu: Exporter des fonctions
template: jaxon
---

Voici comment exporter une fonction.

```php
use Jaxon\Jaxon;

function hello_world($isCaps)
{
    if ($isCaps)
        $text = 'HELLO WORLD!';
    else
        $text = 'Hello World!';

    $xResponse = new Response();
    $xResponse->assign('div1', 'innerHTML', $text);

    return $xResponse;
}

$jaxon->register(Jaxon::USER_FUNCTION, "hello_world");
```

Après avoir été exportée, cette fonction peut être appelée en javascript avec le nom `jaxon_hello_world()`.
Le préfixe `jaxon_` peut être changé à l'aide de l'option de configuration `core.prefix.function`.

Voici un exemple de code HTML qui appelle la fonction PHP exportée avec Jaxon.

```html
<input type="button" value="Submit" onclick="jaxon_hello_world()" />
```

Une méthode d'une classe peut aussi être exportée comme une fonction. Pour cela, le deuxième paramètre de la fonction `register()` doit être un tableau, comme dans l'exemple suivant.

```php
use Jaxon\Jaxon;

class HelloWorld
{
    public function sayHello($isCaps)
    {
        if ($isCaps)
            $text = 'HELLO WORLD!';
        else
            $text = 'Hello World!';

        $xResponse = new Response();
        $xResponse->assign('div2', 'innerHTML', $text);

        return $xResponse;
    }
}

$hello = new HelloWorld;
$jaxon->register(Jaxon::USER_FUNCTION, array("hello_world", $hello, "sayHello"));
```

Si le tableau contient 2 éléments, la fonction javascript générée aura le même nom que la méthode.

```php
$jaxon->register(Jaxon::USER_FUNCTION, array($hello, "sayHello"));
```
