---
title: Enregistrer des classes PHP
menu: Classes
template: jaxon
---

#### Les classes

La section `app.classes` de la configuration contient un tableau de classes à exporter.

En voici un exemple.

```php
class HelloWorld
{
    public function sayHello($isCaps)
    {
        $response = jaxon()->newResponse();
        $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
        $response->assign('div2', 'innerHTML', $text);
    }

    public function setColor($sColor)
    {
        $response = jaxon()->newResponse();
        $response->assign('div2', 'style.color', $sColor);
    }
}
```

```php
    'app' => [
        'classes' => [
            'HelloWorld',
            'OtherClass',
        ],
    ],
```

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```

Après avoir été enregistrée, les méthodes publiques de la classe sont dans une classe javascript nommée `HelloWorld`.

Voici le code javascript généré par Jaxon.

```javascript
JaxonHelloWorld = {};
JaxonHelloWorld.sayHello = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'sayHello' }, { parameters: arguments }
    );
};
JaxonHelloWorld.setColor = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'setColor' }, { parameters: arguments }
    );
};
```

#### Définir les options

Des options peuvent être ajoutées aux méthodes des classes.

```php
    'app' => [
        'classes' => [
            'HelloWorld' => [
                'functions' => [
                    'setColor' => [
                        'mode' => "'synchronous'"
                    ],
                    '*' => [
                        'mode' => "'asynchronous'"
                    ],
                ],
            ],
        ],
    ],
```

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, [
    'functions' => [
        'setColor' => [
            'mode' => "'synchronous'"
        ],
        '*' => [
            'mode' => "'asynchronous'"
        ]
    ]
]);
```

Le code javascript généré est le suivant.

```js
JaxonHelloWorld.sayHello = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'sayHello' }, { parameters: arguments, mode: 'asynchronous' }
    );
};
JaxonHelloWorld.setColor = function() {
    return jaxon.request(
        { jxncls: 'HelloWorld', jxnmthd: 'setColor' }, { parameters: arguments, mode: 'synchronous' }
    );
};
```

#### Autoloading d'une classe

Lors de l'enregistrement d'une classe, l'option `include` permet d'indiquer le chemin du fichier dans lequel la classe est définie.

```php
use Jaxon\Jaxon;

jaxon()->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, ['include' => '/path/to/dir/HelloWorld.php']);
```

Ce fichier sera inclus dans l'application uniquement si une méthode de la classe est appelée.
