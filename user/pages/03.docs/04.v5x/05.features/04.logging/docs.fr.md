---
title: La gestion des logs
menu: Les logs
template: jaxon
---

Jaxon n'implémente pas de fonction de logging, mais supporte l'interface du standard `PSR 3`, qui lui permet d'utiliser des librairies tierces.

Une instance d'un logger doit donc être passée à la librairie au démarrage de l'application, pour qu'elle puisse écrire des messages dans les logs.
Sans cet appel, Jaxon utilise par défaut le logger `Psr\Log\NullLogger`, et tous les messages écrits sont donc perdus.

```php
use Psr\Log\LoggerInterface;

/** @var LoggerInterface $logger */
jaxon()->di()->setLogger($logger)
```

Les messages sont écrits dans les logs avec cet appel.

```php
jaxon()->logger()->debug('This is a message');
```

Les classes de composant fournissent également une méthode `logger()`.

```php
class Component extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $this->logger()->debug('This is a message');
    }
}
```

### La facade Logger

À partir de la version `5.3.1`, Jaxon intègre le package [https://github.com/lagdo/facades](https://github.com/lagdo/facades).
Ce package fournit une facade pour les logs, que la librairie Jaxon configure par défaut pour utiliser le logger défini dans son conteneur.

```php
use Lagdo\Facades\Logger;

class Component extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        Logger::debug('This is a message');
    }
}
```

### Frontend logging

La librairie Javascript de Jaxon peut être configurée pour envoyer ses messages de logs vers l'application PHP sur le serveur, qui va les écrire dans le système de logs.
Cette fonction est inactive par défaut, et doit être explicitement activée à l'aide d'une option de configuration.

```php
jaxon()->setAppOption('options.logging.enabled', true);
```
Ou
```php
    'app' => [
        'options' => [
            'logging' => [
                'enabled' => true
            ],
        ],
    ],
```

Lorsque cette option est activée, Jaxon exporte un [composant](../../components/types.html) `Logger` en Javascript, qui sera appelé chaque fois qu'un message est écrit.
Le composant `Logger` transmet simplement tous les messages qu'il reçoit au système de logs.
