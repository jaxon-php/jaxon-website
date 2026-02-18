---
title: L'injection de dépendance
menu: L'injection de dépendance
template: jaxon
---

La librairie Jaxon permet de passer des classes ou des interfaces en paramètres des constructeurs des classes Jaxon.

Le conteneur de dépendances est configuré à l'initialisation de la librairie ou dans son [fichier de configuration](../../about/configuration.html).
Les dépendances sont passées aux classes soit dans leur constructeur, soit à l'aide d'un attribut ou d'une annotation.

### Le conteneur de dépendances

Le conteneur de dépendances est obtenu à l'aide d'un appel à `jaxon()->di()`.
Il fournit cinq fonctions pour configurer les dépendances.

- Définir une fonction qui renvoie une dépendance.

```php
use Jaxon\Di\Container;

jaxon()->di()->set(\Name\Space\Class\Name::class, function(Container $di) {
    // Retourner l'instance de la classe.
    // La variable $di permet de récupérer d'autres valeurs dans le conteneur.
});
```

- Découvrir automatiquement les dépendances d'une classe en analysant son constructeur.

```php
jaxon()->di()->auto(\Name\Space\Auto\Name::class);
```

- Définir un alias d'une dépendance.

```php
jaxon()->di()->alias(\Name\Space\Interface\Name::class, \Name\Space\Class\Name::class);
```

- Définir la valeur d'une dépendance.

```php
jaxon()->di()->val('di_var_id', $varValue);
```

- Etendre une dépendance, qui doit déjà avoir été définie.

```php
use Jaxon\Di\Container;

jaxon()->di()->extend(\Name\Space\Class\Name::class, function(Container $di) {
    // Modifier et retourner l'instance de la classe.
    // La variable $di permet de récupérer d'autres valeurs dans le conteneur.
});
```

Les dépendances peuvent également être définies dans le [fichier de configuration](../../about/configuration.html).

```php
use Jaxon\Di\Container;

    'app' => [
        'container' => [
            'set' => [
                \Name\Space\Class\Name::class => function(mixed $instance, Container $di) {
                    // Retourner l'instance de la classe.
                    // La variable $di permet de récupérer d'autres valeurs dans le conteneur.
                },
            ],
            'auto' => [
                \Name\Space\Auto\Name::class,
            ],
            'alias' => [
                \Name\Space\Interface\Name::class => \Name\Space\Class\Name::class,
            ],
            'val' => [
                'di_var_id' => $varValue,
            ],
            'extend' => [
                \Name\Space\Class\Name::class => function(mixed $instance, Container $di) {
                    // Modifier et retourner l'instance de la classe.
                    // La variable $di permet de récupérer d'autres valeurs dans le conteneur.
                },
            ],
        ],
    ],
```

### Utilisation des dépendances

Les dépendances sont passées en paramètre aux constructeurs des classes.

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

Dans les classes de composants Jaxon, il est également possible d'utiliser des attributs ou des annotations.

- Avec les attributs.

```php
use Jaxon\Attributes\Attribute\Inject;
use Name\Space\Class\Name;

#[Inject('service', Name::class)]
class Test extends \Jaxon\App\FuncComponent
{
    protected $service;
}
```

- Avec les annotations.

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
Dans ce cas, elle ne concerne que les requêtes vers la méthode annotée.

- Avec les attributs.

```php
use Jaxon\Attributes\Attribute\Inject;
use Name\Space\Class\Name;

class Test extends \Jaxon\App\FuncComponent
{
    /**
     * @var Name
     */
    protected $service;

    #[Inject('service')]
    public function doThat()
    {
        $value = $this->service->do();
        // ...
    }
}
```

- Avec les annotations.

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

Il est également possible lire une dépendance directement dans le conteneur.
Le conteneur est obtenu soit en injectant la classe `Jaxon\Di\Container`, soit avec l'appel à `jaxon()->di()`.

Les méthodes `g()` et `get()` prennent en paramètre l'identifiant d'une dépendance, et retournent sa valeur.
La méthode `get()` recherche d'abord la dépendance dans un conteneur tiers, décrit dans le paragraphe suivant.

### Etendre le conteneur des dépendances

Le conteneur de dépendances de jaxon peut être étendu à l'aide d'un autre conteneur `PSR-11`.
Cette fonctionnalité est utilisée par exemple lors de l'intégration de Jaxon dans un framework, et permet d'injecter dans les classes Jaxon des dépendances définies dans le conteneur du framework.

```php
use Psr\Container\ContainerInterface;

/**
 * @var ContainerInterface $xContainer
 */
jaxon()->di()->setContainer($xContainer);
```
