---
title: L'API JQuery PHP
menu: L'API JQuery PHP
template: jaxon
---

L'objet `Jaxon\Response\Response` fournit des fonctions pour mettre à jour le contenu et la présentation d'une page web.
Chacune de ces fonctions exécute une action sur un élément identifié par son id.
Par exemple, le code suivant définit le texte et la couleur de l'élément avec l'id `message`.

```php
$response->assign('message', 'innerHTML', 'Yaba daba doo');
$response->assign('message', 'style.font-size', 'blue');
```

Ces fonctions ont quelques limitations: elles ne peuvent s'appliquer qu'à un élément de la page à la fois, et elles impose que cet élément ait un attribut HTML `id`.

#### La nouvelle API

L'API jQuery PHP copie le comportement et la syntaxe de la librairie javascript [jQuery](https://www.jquery.com).
En réalité elle génère automatiquement le code javascript qui appelle les fonctions de jQuery.

L'API jQuery PHP permet d'utiliser les mêmes sélecteurs que la librairie jQuery, et donc d'appliquer une fonction simultanément sur plusieurs éléments d'une page web, sélectionnés avec des critères variés.
Elle est simple à apprendre pour ceux qui connaissent jQuery. Cependant, elle nécessite de charger la librairie jQuery dans la page pour fonctionner.
#### Exemples

Dans la version 1 de Jaxon, elle est disponible [dans un plugin](https://github.com/jaxon-php/jaxon-jquery), et elle est intégrée à la version 2.

Exemple avec la version 2.

```php
$response->jquery('#message')->html('Yaba daba doo')->css('font-size', 'blue');
```

Et avec la version 1.

```php
$response->jquery->element('#message')->html('Yaba daba doo')->css('font-size', 'blue');
```

L'API jQuery PHP de Jaxon est [documentée ici](/docs/responses/jquery).