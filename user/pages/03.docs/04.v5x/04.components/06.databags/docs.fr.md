---
title: Les databags
menu: Les databags
template: jaxon
---

Les `databags` sont des données de l'application qui sont stockées dans le navigateur, et envoyées à la demande dans les requêtes ajax vers les classes Jaxon.
Elles conviennent aux données qui doivent être disponibles dans l'application, mais ne sont utilisées que par certains composants.

Chaque `databag` possède un identifiant qui doit être unique dans toute l'application, et chacune de ses données est stockée sous une clé qui doit être unique dans le `databag`.

Pour pouvoir lire les données d'un `databag` dans une méthode d'une classe Jaxon, il faut explicitement demander que son contenu soit envoyé dans les requêtes vers cette méthode.

Cela se fait avec des attributs ou des annotations dans la classe, dans le [fichier de configuration](../../about/configuration.html), ou [avec des appels à la fonction jaxon()->register()](../../registrations/namespaces.html).

#### Note sur la sécurité

Les données des `databags` étant stockées dans le navigateur, sont accessibles aux utilisateurs. Il ne faut donc pas y placer des données sensibles.
De même, elles doivent stocker le moins de données possible, car elles augmentent la taille des requêtes Jaxon.

#### Attribut

L'attribut `Jaxon\Attributes\Attribute\Databag` est défini sur une classe ou une méthode pour configurer les `databags`.
Il prend en paramètre son identifiant unique, et peut être repété pour définir plusieurs `databags`.

Si l'attribut est défini sur une classe Jaxon, alors toutes ses méthodes recevront le contenu du `databag`.

```php
namespace Ns\App;

use Jaxon\Attributes\Attribute\Databag;

#[Databag('bag_key')]
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

Si l'attribut est défini sur une méthode, celle-ci sera alors la seule à recevoir le contenu du `databag`.

```php
namespace Ns\App;

use Jaxon\Attributes\Attribute\Databag;

class SecondClass extends \Jaxon\App\FuncComponent
{
    #[Databag('bag_key')]
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

#### Annotation

L'annotation `@databag` est définie sur une classe ou une méthode pour configurer les `databags`.
Elle prend en paramètre son identifiant unique, et peut être repétée pour définir plusieurs `databags`.

Si l'annotation est définie sur une classe Jaxon, alors toutes ses méthodes recevront le contenu du `databag`.

```php
namespace Ns\App;

/**
 * @databag bag_key
 */
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

Si l'annotation est définie sur une méthode, celle-ci sera alors la seule à recevoir le contenu du `databag`.

```php
namespace Ns\App;

class SecondClass extends \Jaxon\App\FuncComponent
{
    /**
     * @databag bag_key
     */
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

#### Configuration

Avec les configurations ci-dessous, le `databag` **bag_key** sera passé dans les requêtes vers toutes les méthodes de la classe `\Ns\App\FirstClass`, et dans les requêtes vers la méthode `doThat()` de la classe `\Ns\App\SecondClass`.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\FirstClass::class => [
            'functions' => [
                '*' => [
                    'bags' => ["'bag_key'"]
                ]
            ]
        ],
        \Ns\App\SecondClass::class => [
            'functions' => [
                'doThat' => [
                    'bags' => ["'bag_key'"]
                ]
            ]
        ]
    ]
]);
```

```php
    'app' => [
        'directories' => [
            '/the/class/dir' => [
                'namespace' => 'Ns',
                // 'autoload' => true,
                // 'separator' => '.',
                // 'protected' => [],
                'classes' => [
                    \Ns\App\FirstClass::class => [
                        'functions' => [
                            '*' => [
                                'bags' => ["'bag_key'"]
                            ]
                        ]
                    ],
                    \Ns\App\SecondClass::class => [
                        'functions' => [
                            'doThat' => [
                                'bags' => ["'bag_key'"]
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ]
```

```php
namespace Ns\App;

class SecondClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
    }
}
```

#### Accès aux `databags`

Toutes les classes de composants de Jaxon possèdent une fonction `bag()` qui prend en paramètre un identifiant et renvoie l'objet `databag` correspondant.
L'objet `databag` possède deux fonctions `set()` et `get()` qui permettent respectivement de définir ou lire une valeur dans le `databag`.

```php
/**
 * @databag bag_key
 */
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function save()
    {
        // The value is saved in the browser.
        $this->bag('bag_key')->set('value_key', $value);
    }

    public function read()
    {
        // The value is sent from the browser to the application.
        $value = $this->bag('bag_key')->get('value_key');
    }
}
```

#### Fonctions Javascript

La librairie Javascript fournit des fonctions pour lire ou modifier les valeurs des `databags`.
Ces fonctions peuvent être utilisées par exemple pour passer une partie du contenu d'un `databag` en paramètre à un appel.

Les fonctions `jaxon.bag.getEntry(sBagName, sBagKey)` et `jaxon.bag.setEntry(sBagName, sBagKey, xValue)` lisent ou définissent le contenu d'une entrée du `databag`.

Les fonctions `jaxon.bag.getValue(sBagName, sBagKey, sDataKey, xDefault)` et `jaxon.bag.setValue(sBagName, sBagKey, sDataKey, xValue)` lisent ou définissent une valeur dans le contenu d'une entrée du `databag`.
Le contenu de l'entrée doit être un objet Javascript, et la présence de points dans la valeur du paramètre `sDataKey` donne accès à des valeurs imbriquées dans ce contenu.
