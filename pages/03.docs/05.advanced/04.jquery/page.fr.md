---
title: L'API JQuery PHP
menu: JQuery PHP
template: jaxon
---

L'objet `Jaxon\Response\Response` fournit des fonctions pour mettre à jour [le contenu et le style d'une page web](/docs/response/webpage).
Chacune de ces fonctions exécute une action sur un élément identifié par son attribut `id`.

Ces fonctions ont quelques limitations: elles ne peuvent s'appliquer qu'à un élément de la page à la fois, et elles impose que cet élément ait un attribut HTML `id`.

#### La nouvelle API

L'API jQuery PHP copie le comportement et la syntaxe de la librairie javascript [jQuery](https://www.jquery.com).
En réalité elle génère automatiquement des appels aux fonctions de jQuery.

L'API jQuery PHP permet d'utiliser les mêmes sélecteurs que la librairie jQuery, et donc d'appliquer une fonction simultanément sur plusieurs éléments d'une page web, sélectionnés avec des critères variés.
Elle est simple à apprendre pour ceux qui connaissent jQuery. Cependant, elle nécessite de charger la librairie jQuery dans la page pour fonctionner.

L'API jQuery est fournie par le plugin [jaxon-jquery](https://github.com/jaxon-php/jaxon-jquery), qui a été intégré à la librairie dans la version 2.

#### Utiliser l'API (Dans Jaxon version 2)

L'API fonctionne de la même manière que celle de la librairie javascript.
Une première fonction sélectionne les éléments sur lequels on souhaite agir, et une ou plusieurs autres fonctions leur appliquent les traitements souhaités.
Toutes ces fonctions peuvent être chaînées dans un seul appel.

La fonction qui sélectionne les éléments est `jQuery()`. C'est une méthode de la classe `Response`.

```php
$response->jQuery('#message')->html('Yaba daba doo')->css('color', 'blue');
```

SOn premier paramètre est un sélecteur (voir la [documentation de jQuery](http://api.jquery.com/jQuery/)).
Le second, optionnel, est un contexte qui permet de limiter la sélection à une partie de la page web.

Chaque appel suivant peut modifier le contenu ou le style de chaque élément de la sélection,

```php
$response->jQuery('#message')->html('Yaba daba doo')->css('color', 'blue');
```

ou bien lier un évènement à une fonction javascript sur chaque élément de la sélection,

```php
$response->jQuery('#message')->click(rq()->func('alert', 'You clicked on the message'));
```

ou enfin écrire ou lire la valeur d'un attribut du premier élément de la sélection.

```php
$response->jQuery('#message')->value = 'Yaba daba doo';
```

#### Les paramètres des fonctions

Le méthode `jQuery()` accepte les mêmes [sélecteurs que jQuery](http://api.jquery.com/category/selectors/).

Les paramètres des appels suivants peuvent être de type booléen, entier, caractères ou tableau.
Il est également possible de passer du contenu de la page web en paramètre des appels, en utilisant la fonction globale `jQuery()`,

```php
$response->jQuery('#message')->html(jQuery('#message2')->html());
```

ou encore la [fabrique de requête](/docs/requests/factory).

```php
$response->jQuery('#message')->html(rq()->html('message2'));
```

Une fonction Jaxon peut être passée en paramètre, pour la lier à un évènement.

```php
$response->jQuery('#button')->click(rq()->call('MyClass.myMethod'));
```

La fonction globale `jQuery()` peut être appelée sans paramètre.
Cela permet dans le contexte de l'exécution d'une callback, d'accéder à l'élément en cours de traitement, soit l'équivalent de la variable javascript `this`.

Dans l'exemple suivant un click sur chaque bouton appellera la fonction Jaxon avec un paramètre différent, donné par l'attribut `data-name` de l'élément parent du bouton.

```php
$request = rq()->call('MyClass.myMethod', jQuery()->parent()->attr('data-name'));
$response->jQuery('.btn')->click($request);
```

Cette syntaxe peut également être utilisée pour inclure du contenu de la page web dans une question de confirmation.

```php
$request = rq()->call('MyClass.myMethod')
    ->confirm('Confirm the name {1}?', jQuery()->parent()->attr('data-name'));
$response->jQuery('.btn')->click($request);
```

#### Compatibilité avec jQuery

L'API jQuery PHP génère automatiquement le code javascript correspondant aux appels qu'il a reçus, en utilisant la fonction `$()` pour les sélecteurs.
Il n'y donc pas de restriction sur des versions particulières de la librairie `jQuery`, mais plutôt sur les fonctions qui peuvent être utilisées.

De façon générale, l'API permet d'utiliser uniquement les fonctions jQuery qui s'appliquent à des sélecteurs.
Cela inclut:

- Les attributs [http://api.jquery.com/category/attributes/](http://api.jquery.com/category/attributes/)
- Le DOM [http://api.jquery.com/category/traversing/](http://api.jquery.com/category/traversing/)
- Le CSS [http://api.jquery.com/category/css/](http://api.jquery.com/category/css/), à l'exception des méthodes de l'objet `jQuery`.
- Les évènements [http://api.jquery.com/category/events/](http://api.jquery.com/category/events/), mais seulement ceux qui sont liés à des sélecteurs.
