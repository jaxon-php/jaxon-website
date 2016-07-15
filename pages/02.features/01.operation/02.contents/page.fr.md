---
title: Modifier le contenu des pages
menu: Contenu des pages
template: jaxon
---

Une fonction Jaxon renvoie un objet `Jaxon\Jaxon\Response`, qui fournit des fonctions pour réaliser différents types d'opérations dans la page web. De nouvelles fonctions peuvent lui être ajoutées à l'aide de plugins.

La liste complète des fonctions de la classe `Jaxon\Response\Response` est [documentée ici](/api/Jaxon/Plugin/Response.html).

#### Le contenu de la page

Les fonctions suivantes mettent à jour le contenu de la page web.

```php
// Assign the specified value to the element with id "content"
$response->assign('content', 'innerHTML', $sData);
```

```php
// Append the specified data to the element with id "content"
$response->append('content', 'innerHTML', $sData);
```

```php
// Prepend the specified data to the element with id "content"
$response->prepend('content', 'innerHTML', $sData);
```

#### Les propriétés CSS

Les fonctions suivantes appliquent des propriétés CSS au contenu de la page web.

```php
// Set the specified CSS class to the element with id "content"
$response->assign('content', 'className', 'main_content');
```

```php
// Set the background color on the element with id "content"
$response->assign('content', 'style.background', 'blue');
```

#### Les fonctions javascript

La fonction suivante exécute un code javascript dans la page web.

```php
$response->script('var done = true;');
```

La fonction suivante affiche un message dans la page web.

```php
$response->alert('Done!!');
```

#### Les plugins

Les plugins de Jaxon ajoutent de nouvelles fonctions à l'objet `Jaxon\Jaxon\Response`.
Une fois installé, le plugin est accessible dans l'objet `Jaxon\Jaxon\Response` à l'aide de son identifiant unique.

Par exemple, le plugin [jaxon-toastr](https://github.com/jaxon-php/jaxon-toastr) ajoute des notifications à une application.
```php
$response->toastr->success("You are now using the Toastr Notification plugin!!");
```
