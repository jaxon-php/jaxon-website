---
title: Callbacks
menu: Callbacks
template: jaxon
published: true
---

Jaxon permet définir des callbacks qui vont être appelées à différents étapes de l'exécution de chaque requête.

#### Avant l'exécution de la requête

```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, array($object, 'methodName'));
```

La fonction à appeler prend en paramètre un booléen `$bEndRequest` passé par référence, et retourne une réponse Jaxon. La paramètre à la valeur `false` avant l'appel à la fonction.
Si dans la fonction il est modifié et prend la valeur `true`, le traitement est arrêté, et la réponse de la requête est celle renvoyée par la fonction.

```php
function preProcess(&$bEndRequest)
{
}
```

#### Après l'exécution de la requête

```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_AFTER, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_AFTER, array($object, 'methodName'));
```

La fonction à appeler prend en paramètre un booléen, qui est le même qui a été passé à la fonction de `pre-processing`. Il indique donc si la requête Jaxon a été traitée.
Si cette fonction renvoie une réponse Jaxon, elle est ajoutée à la réponse courante.

```php
function postProcess($bEndRequest)
{
}
```

#### En cas de requête invalide

```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, array($object, 'methodName'));
```

La fonction à appeler prend en paramètre le message d'erreur renvoyé lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée, et si cette fonction en renvoie une, ce sera aussi celle de la requête.

```php
function invalidRequest($sMessage)
{
}
```

#### En cas d'erreur lors de l'exécution de la requête

Cette callback a été ajoutée à la version 2.

```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_ERROR, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_ERROR, array($object, 'methodName'));
```

La fonction à appeler prend en paramètre l'exception levée lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée, et si cette fonction en renvoie une, ce sera aussi celle de la requête.

```php
function invalidRequest($xException)
{
}
```
