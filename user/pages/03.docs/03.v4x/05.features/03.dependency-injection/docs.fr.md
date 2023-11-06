---
title: L'injection de dépendance
menu: L'injection de dépendance
template: jaxon
---

Depuis la version 3, la librairie Jaxon permet de passer des classes ou des interfaces en paramètres des constructeurs des classes Jaxon.

Le conteneur de dépendances est configuré à l'initialisation de la librairie ou dans son [fichier de configuration](../01.bootstrap/).
Les dépendances sont passées aux classes Jaxon soit dans leur constructeur, soit à l'aide d'une annotation.

### Le conteneur de dépendances

Le conteneur de dépendances est obtenu à l'aide d'un appel à `jaxon()->di()`.
Il fournit quatre fonctions pour configurer les dépendances.

Définir la fonction qui renvoie une dépendance.

```php
jaxon()->di()->set(\Name\Space\Class\Name::class, function($di) {
    // Retourner l'instance de la classe.
    // La variable $di permet de récupérer d'autres valeurs dans le conteneur.
});
```

Découvrir automatiquement les dépendances d'une classe en analysant son constructeur.

```php
jaxon()->di()->auto(\Name\Space\Auto\Name::class);
```

Définir un alias d'une dépendance.

```php
jaxon()->di()->alias(\Name\Space\Interface\Name::class, \Name\Space\Class\Name::class);
```

Définir la valeur d'une dépendance.

```php
jaxon()->di()->val('di_var_id', $varValue);
```

Les dépendances peuvent également être définies dans le [fichier de configuration](../01.bootstrap/).

```php
    'app' => [
        'container' => [
            'set' => [
                \Name\Space\Class\Name::class => function($di) {
                    // Retourner l'instance de la classe.
                    // La variable $di permet de récupérer d'autres valeurs dans le conteneur.
                }
            ],
            'auto' => [
                \Name\Space\Auto\Name::class,
            ],
            'alias' => [
                \Name\Space\Interface\Name::class => \Name\Space\Class\Name::class
            ],
            'val' => [
                'di_var_id' => $varValue
            ],
        ],
    ],
```

### Utilisation des dépendances

Les dépendances sont passées en paramètre aux constructeurs des classes Jaxon.

```php
class Test extends \Jaxon\App\CallableClass
{
    protected $service;

    public function __construct(\Name\Space\Class\Name::class $service)
    {
        $this->service = $service;
    }
}
```

Il est également possible d'utiliser [les annotations](../../06.annotations/02.di/), qui offrent plus de possibilités.

```php
/**
 * @di $service \Name\Space\Class\Name
 */
class Test extends \Jaxon\App\CallableClass
{
    protected $service;
}
```

Ou encore,

```php
class Test extends \Jaxon\App\CallableClass
{
    /**
     * @di
     * @var \Name\Space\Class\Name
     */
    protected $service;
}
```

Les dépendances peuvent aussi être injectées directement dans une méthode.

```php
class Test extends \Jaxon\App\CallableClass
{
    /**
     * @var \Name\Space\Class\Name
     */
    protected $service;

    /**
     * @di $service
     */
    public function doThat()
    {
        $value = $this->service->do();
        // ...
        return $this->response;
    }
}
```
