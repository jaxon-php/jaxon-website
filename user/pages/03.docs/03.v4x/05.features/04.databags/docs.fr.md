---
title: Les data bags
menu: Les data bags
template: jaxon
---

Les `data bags` sont des données stockées sur le client, et envoyées à la demande dans les requêtes ajax vers les classes Jaxon.
Elles conviennent aux données qui doivent être disponibles dans une application, mais ne sont utilisées qu'occasionnellement.

Chaque `data bag` possède un identifiant qui doit être unique dans toute l'application, et chacune de ses données est stockée sous une clé qui doit être unique dans le `data bag`.

### Création

Pour créer un `data bag`, il suffit d'y stocker une première valeur dans une méthode d'une classe Jaxon.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    public function doThat()
    {
        $this->bag('bag_key')->set('value_key', $value);

        return $this->response;
    }
}
```

Le `data bag` sera envoyé dans la réponse Jaxon et enregistré dans l'application côté client.

### Utilisation

Pour pouvoir lire les données d'un `data bag` dans une méthode d'une classe Jaxon, il faut explicitement demander que son contenu soit envoyé dans les requêtes vers cette méthode.

Cela se fait à l'enregistrement [d'une classe](../../02.registrations/02.classes/) ou [d'un répertoire](../../02.registrations/03.directories/), ou dans le [fichier de configuration](../01.bootstrap/).

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

Avec cette configuration, le `data bag` **bag_key** sera passé dans les requêtes vers toutes les méthodes de la classe `\Ns\App\FirstClass`, et dans les requêtes vers la méthode `doThat()` de la classe `\Ns\App\SecondClass`.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
        return $this->response;
    }
}
```

### Annotation

[L'annotation `@databag`](../../06.annotations/03.databags/) permet de configurer les `data bags`.

Si l'annotation est définie sur une classe Jaxon, alors toutes ses méthodes recevront le `data bag`.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

/**
 * @databag bag_key
 */
class FirstClass extends CallableClass
{
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
        return $this->response;
    }
}
```

Si l'annotation est définie sur des méthodes, celles-ci seront alors les seules à recevoir le `data bag`.

```php
namespace Ns\App;

use Jaxon\App\CallableClass;

class SecondClass extends CallableClass
{
    /**
     * @databag bag_key
     */
    public function doThat()
    {
        $bagValue = $this->bag('bag_key')->get('value_key');
        // ...
        return $this->response;
    }
}
```
