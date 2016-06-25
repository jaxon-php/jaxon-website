---
title: L'API de réponse
menu: L'API
template: jaxon
---

Une réponse Jaxon contient une liste de commandes à exécuter dans le navigateur en réponse à une requête Jaxon.
La classe `Jaxon\Response\Response` implémente un ensemble de fonctions qui permettent chacune de lui ajouter une commande qui exécute une action dans le navigateur.

Par exemple, le code suivant affiche un message d'alerte.
```php
$response->alert('What you say?!');
``` 

Le code suivant affecte un texte à un bloc HTML identifié par son id.
```php
$response->assign('message-id', 'innerHTML', 'Jaxon is cool');
``` 

La liste complète des fonctions de la classe `Jaxon\Response\Response` est [documentée ici](http://www.jaxon-php.org/docs/api/class-Jaxon.Response.Response.html).

Bien que la classe `Jaxon\Response\Response` implémente une longue liste de fonctions, il est possible de lui en ajouter à l'aide de [plugins](../../plugins/response).
