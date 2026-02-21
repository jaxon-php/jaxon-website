---
title: Callbacks PHP
menu: Callbacks PHP
template: jaxon
published: true
---

Jaxon permet définir des fonctions globales qui vont être appelées à différents étapes de l'exécution de chaque requête dans l'application PHP.

### Au démarrage de la librairie

Les callbacks définies ici sont appelées juste après le démarrage de la librairie, mais avant l'exécution de la requête.
Elles serviront par exemple pour les opérations à exécuter après que la librairie soit configurée ou que le conteneur de dépendances soit mis à jour.

```php
$jaxon->callback()->boot(function() {});
```

### Avant l'exécution de la requête

```php
$jaxon->callback()->before(function($target, &$bEndRequest) {});
```

La callback fournie doit accepter les paramètres suivants.

```php
/**
 * @param Jaxon\Request\Target  $target         La fonction ou la méthode de classe à appeler.
 *
 * @return bool
 */
```

Le paramètre `$target` permet de retrouver la fonction ou la classe appelée de la façon suivante.

```php
    if($target->isFunction())
    {
        $function = $target->getFunctionName();
    }
    if($target->isClass())
    {
        $class = $target->getClassName();
        $method = $target->getMethodName();
    }
```

Si la callback retourne la valeur `true`, le traitement est arrêté, et la réponse renvoyée par la est renvoyée au navigateur.

### Après l'exécution de la requête

```php
$jaxon->callback()->after(function($target, $bEndRequest) {});
```

Le paramètre `$target` est le même que pour la callback `before()`, et `$bEndRequest` sa valeur de retour.

### En cas de requête invalide

```php
$jaxon->callback()->invalid(function($sMessage) {});
```

Le paramètre de la callback est le message d'erreur renvoyé lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée avant l'exécution de la callback.

### En cas d'erreur lors de l'exécution de la requête

```php
$jaxon->callback()->error(function($xException) {});
```

Le paramètre de la callback est l'exception levée lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée avant l'exécution de la callback.

Un nom de classe d'exception peut être passé en deuxième paramètre à la fonction `error()`.
Dans ce cas, la callback ne sera appelée que si l'exception correspond à cette classe.
