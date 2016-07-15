---
title: Evènement post-processing
menu: Post-processing
template: jaxon
---

Jaxon permet d'indiquer une fonction callback qui va être appelée après l'exécution de chaque requête.
Elle est définie de l'une des façons suivantes.
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
