---
title: Traiter les requêtes Jaxon
menu: Traitement
template: jaxon
---

Quelque soit le nombre de classes PHP qu'elle exporte vers javascript, une application qui utilise la librairie Jaxon a besoin d'une seule route pour toutes les requêtes vers ces classes.

Le code le plus simple à attacher à cette route pour traiter une requête vers une classe Jaxon est le suivant:

```php
$jaxon = jaxon();
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);

if($jaxon->canProcessRequest())
{
    $jaxon->processRequest();
}
```

La méthode `processRequest()` appelle la fonction ou la classe indiquée dans la requête et renvoie la réponse au client.
