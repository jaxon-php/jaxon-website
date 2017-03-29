---
title: Editer le contenu des pages web
menu: Edition des pages
template: jaxon
---

L'objet `Jaxon\Jaxon\Response` (voir son [API](/api/Jaxon/Plugin/Response.html)) fournit des fonctions pour réaliser 3 types d'opérations dans la page web.

- Modifier le contenu (texte) de la page
- Modifier la présentation de la page avec CSS
- Exécuter du code javascript dans la page

##### Modifier le contenu de la page

```php
// Définir le contenu de l'élément ayant pour id "content".
$response->assign('content', 'innerHTML', $sData);

// Ajouter du contenu au début de l'élément ayant pour id "content".
$response->append('content', 'innerHTML', $sData);

// Ajouter du contenu à la fin de l'élément ayant pour id "content".
$response->prepend('content', 'innerHTML', $sData);
```

##### Modifier la présentation de la page

```php
// Définir la classe CSS class de l'élément ayant pour id "content".
$response->assign('content', 'className', 'main_content');

// Définir la couleur de fond de l'élément ayant pour id "content".
$response->assign('content', 'style.background', 'blue');
```

##### Exécuter du code javascript

```php
// Exécuter du code javascript dans la page web.
$response->script('var done = true;');

// Afficher un message dans la page web.
$response->alert('Done!!');
```

#### L'API PHP jQuery

Les fonctions de modification du contenu et de la présentation des pages web ci-dessus manquent de flexibilité car elles agissent chacune sur un seul élément de la page, identifié par son id.

L'objet `Jaxon\Jaxon\Response` [fournit des fonctions](/docs/responses/jquery) inspirées de la librairie javascript [jQuery](https://www.jquery.com), qui permet de sélectionner des éléments d'une page par leur id ou leur classe, et d'agir simultanément sur plusieurs éléments.

```php
$response->jquery('div.box')->css('background-color', 'blue')->css('font-size', '20px')->html('Na popo helele!');
```

#### Les plugins

Les plugins de Jaxon ajoutent de nouvelles fonctions à l'objet `Jaxon\Jaxon\Response`.
Une fois installé, le plugin est accessible dans l'objet `Jaxon\Jaxon\Response` à l'aide de son identifiant unique.

Par exemple, le plugin [jaxon-toastr](https://github.com/jaxon-php/jaxon-toastr) ajoute des notifications à une application.
```php
$response->toastr->success("You are now using the Toastr Notification plugin!!");
```
