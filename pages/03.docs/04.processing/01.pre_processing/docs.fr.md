---
title: Evènement pre-processing
menu: Pre-processing
template: docs
---

Jaxon permet d'indiquer une fonction callback qui va être appelée avant l'exécution de chaque requête.
Elle est définie de l'une des façons suivantes.
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, 'functionName');
```
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, array($object, 'methodName'));
```

La fonction à appeler prend en paramètre un booléen passé par référence, et retourne une réponse Jaxon. La paramètre à la valeur `false` avant l'appel à la fonction.
Si dans la fonction il est modifié et prend la valeur `true`, le traitement est arrêté, et la réponse de la requête est celle renvoyée par la fonction.
```php
function preProcess(&$bEndRequest)
{
}
```
