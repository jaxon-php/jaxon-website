---
title: Modifier le contenu des pages web avec PHP
menu: Le contenu des pages
template: jaxon
---

L'objet `Response` retourné en réponse à une requête Jaxon contient une liste de commandes à exécuter dans le navigateur.
La classe `Jaxon\Response\Response` fournit un ensemble de fonctions qui lui ajoutent chacune une commande spécidique.

Par exemple, le code suivant affiche un message d'alerte.
```php
$response->alert('What you say?!');
``` 

Le code suivant affecte un texte à un bloc HTML identifié par son id.
```php
$response->assign('message-id', 'innerHTML', 'Jaxon is cool');
``` 

La liste complète des fonctions de la classe `Jaxon\Response\Response` est [documentée ici](/api/Jaxon/Plugin/Response.html).

Bien que la classe `Jaxon\Response\Response` implémente une longue liste de fonctions, il est possible de lui en ajouter à l'aide de [plugins](../../plugins/response).
