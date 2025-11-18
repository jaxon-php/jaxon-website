---
title: La gestion des logs
menu: Les logs
template: jaxon
---

Jaxon n'implémente pas de fonction de logging, mais supporte le standard `PSR 3`, qui lui permet d'utiliser des librairies tierces.

Une instance d'un logger doit donc être passée à la librairie au démarrage de l'application, pour qu'elle puisse écrire des messages dans les logs.

```php
use Psr\Log\LoggerInterface;

/** @var LoggerInterface $logger */
jaxon()->di()->setLogger($logger)
```

Les messages sont alors écrits dans les logs avec cet appel.

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
