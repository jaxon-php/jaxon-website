---
title: L'injection de dépendance
menu: L'injection de dépendance
template: jaxon
---

La librairie Jaxon permet de passer des classes ou des interfaces en paramètres des constructeurs des classes Jaxon.

Le conteneur de dépendances est configuré à l'initialisation de la librairie ou dans son [fichier de configuration](../../about/configuration.html).
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

Les dépendances peuvent également être définies dans le [fichier de configuration](../../about/configuration.html).

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
class Test extends \Jaxon\App\FuncComponent
{
    protected $service;

    public function __construct(\Name\Space\Class\Name::class $service)
    {
        $this->service = $service;
    }
}
```

Il est également possible d'utiliser des annotations.
Dans ce cas, elle ne concerne que les requêtes vers la classe ou la méthode annotée.

```php
/**
 * @di $service \Name\Space\Class\Name
 */
class Test extends \Jaxon\App\FuncComponent
{
    protected $service;
}
```

Ou encore,

```php
class Test extends \Jaxon\App\FuncComponent
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
class Test extends \Jaxon\App\FuncComponent
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
    }
}
```
