---
title: Callbacks PHP
menu: Callbacks PHP
template: jaxon
published: true
---

Jaxon permet définir des callbacks qui vont être appelées à différents étapes de l'exécution de chaque requête dans l'application PHP.

#### Avant l'exécution de la requête

```php
$jaxon->callback()->before(function($target, &$bEndRequest) {});
```

La callback fournie doit accepter les paramètres suivants.

```php
/**
 * @param Jaxon\Request\Target  $target         La fonction ou la méthode de classe à appeler.
 * @param boolean               &$bEndRequest   Mettre ceci à true pour interrompre la requête.
 *
 * @return Jaxon\Response\Response
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

Le paramètre `$bEndRequest` est passé par référence. Sa valeur initiale est `false`, et si il prend la valeur `true` dans la callback, le traitement est arrêté, et la réponse renvoyée par la callback sera envoyée au navigateur.

#### Après l'exécution de la requête

```php
$jaxon->callback()->after(function($target, $bEndRequest) {});
```

Les paramètres sont les mêmes que pour la callback `before()`, sauf que `$bEndRequest` est passé par valeur et non par référence.
Si la callback renvoie une réponse Jaxon, elle est ajoutée à la réponse courante.

#### En cas de requête invalide

```php
$jaxon->callback()->invalid(function($sMessage) {});
```

Le paramètre de la callback est le message d'erreur renvoyé lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée, et si la callback en renvoie une, ce sera aussi celle de la requête.

#### En cas d'erreur lors de l'exécution de la requête

```php
$jaxon->callback()->error(function($xException) {});
```

Le paramètre de la callback est l'exception levée lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée, et si la callback en renvoie une, ce sera aussi celle de la requête.
