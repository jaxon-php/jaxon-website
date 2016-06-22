---
title: Requête invalide
menu: Requête invalide
template: docs
---

Enfin, Jaxon permet d'indiquer une fonction qui être appelée lorsqu'une requête invalide est reçue.
Elle est définie de l'une des façons suivantes.
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, 'functionName');
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, array($object, 'methodName'));
```

La fonction à appeler prend en paramètre le message d'erreur renvoyé lors du traitement de la requête.
La réponse Jaxon à la requête est réinitialisée, et si cette fonction en renvoie une, ce sera aussi celle de la requête.
```php
function invalidRequest($sMessage)
{
}
```
