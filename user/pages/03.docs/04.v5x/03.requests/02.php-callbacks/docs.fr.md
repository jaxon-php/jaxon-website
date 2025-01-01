---
title: Callbacks PHP
menu: Callbacks PHP
template: jaxon
published: true
---

Jaxon permet définir des fonction globales qui vont être appelées à différents étapes de l'exécution de chaque requête dans l'application PHP.

#### Avant l'exécution de la requête

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
    elseif($target->isClass())
    {
        $class = $target->getClassName();
        $method = $target->getMethodName();
    }
```

Si la callback retourne la valeur `true`, le traitement est arrêté, et la réponse renvoyée par la est renvoyée au navigateur.

#### Après l'exécution de la requête

```php
$jaxon->callback()->after(function($target, $bEndRequest) {});
```

Le paramètre `$target` est le même que pour la callback `before()`, et `$bEndRequest` sa valeur de retour.

#### En cas de requête invalide

```php
$jaxon->callback()->invalid(function($sMessage) {});
```

Le paramètre de la callback est le message d'erreur renvoyé lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée avant l'exécution de la callback.

#### En cas d'erreur lors de l'exécution de la requête

```php
$jaxon->callback()->error(function($xException) {});
```

Le paramètre de la callback est l'exception levée lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée avant l'exécution de la callback.
