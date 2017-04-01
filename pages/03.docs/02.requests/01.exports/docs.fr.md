---
title: Exporter des objets et des fonctions PHP
menu: Exporter du code PHP
template: jaxon
---

Voici comment exporter un objet.

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

    public function setColor($sColor)
    {
        $xResponse = new Response();
        $xResponse->assign('div2', 'style.color', $sColor);

        return $xResponse;
    }
}

$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```

Après avoir été exportées, les méthodes publiques de l'objet sont dans la classe javascript nommée `JaxonHelloWorld`.
Le préfixe `Jaxon` peut être changé à l'aide de l'option de configuration `core.prefix.class`.

Voici un exemple de code HTML qui appelle des méthodes de la classe PHP exportée avec Jaxon.
```html
<input type="button" value="Say Hello" onclick="JaxonHelloWorld.sayHello(0)" />
<input type="button" value="Set Color" onclick="JaxonHelloWorld.setColor('red')" />
```
