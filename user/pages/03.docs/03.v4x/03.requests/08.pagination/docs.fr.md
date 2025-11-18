---
title: La pagination
menu: La pagination
template: jaxon
---

La pagination avec Jaxon est différente de la pagination d'une application classique, car là où l'application génère une liste de liens vers des pages différentes, Jaxon doit générer une liste d'appels à une fonction javascript avec des paramètres différents.
Pour Jaxon, les paramètres dans les liens de pagination ne sont pas nommés, et leur position est importante.

Voici un exemple de liens de pagination dans une application classique.
```html
<ul class="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="/items?page=2">2</a></li>
    <li><a class="page-numbers" href="/items?page=3">3</a></li>
    <li><a class="page-numbers" href="/items?page=4">4</a></li>
    <li><a class="page-numbers" href="/items?page=5">5</a></li>
</ul>
```

Avec Jaxon, on devrait avoir plutôt ceci.
```html
<ul class="pagination">
    <li><span class="page-numbers current">1</span></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(2)">2</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(3)">3</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(4)">4</a></li>
    <li><a class="page-numbers" href="javascript:;" onclick="MyClass.showPage(5)">5</a></li>
</ul>
```

La méthode `paginate()` ou `pg()` permet, à partir d'une requête, de générer les liens de pagination vers une méthode d'une classe Jaxon.

```php
$pagination = rq('MyClass')->call('showPage', pm()->select('colorselect'), pm()->page())->paginate($currentPage, $itemsPerPage, $itemsTotal);
```

La position du numéro de page est indiquée par la fonction `pm()->page()`. S'il n'est pas présent dans l'appel, il sera automatiquement ajouté à la fin de la liste des paramètres.
Le résultat est le code HTML à insérer dans la page.

```html
<div class="content">
    <div id="color">
        <select class="form-control" id="colorselect" name="colorselect">
            <option value="black" selected="selected">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>
    </div>
    <div id="pagination-wrapper"><?= $pagination ?></div>
</div>
```

#### Personnalisation de la pagination

Les liens de pagination de Jaxon sont générés à partir de templates, qui par défaut sont fournis par la librairie : [https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination](https://github.com/jaxon-php/jaxon-core/tree/master/templates/pagination).

A la racine du répertoire, il y a le template `wrapper`, qui positionne les liens de pagination et les balises HTML qui les entourent.
La variable de template `links` contient la liste des liens de pagination, tandis que les variables `prev` et `next` contiennent respectivement les liens vers les pages précédente et suivante.
Les variables `prev` et `next` sont vides si le lien correspondant est absent.

Dans le sous-répertoire `links`, il y a un template pour chaque type de lien:

- Le template `current` affiche le lien vers la page courante.
- Le template `enabled` affiche un lien vers une page active.
- Le template `disabled` affiche un lien vers une page inactive.
- Le template `prev` affiche le lien vers la page précédente.
- Le template `next` affiche le lien vers la page suivante.

Dans chaque template, la variable `text` contient le texte à afficher, et la variable `call` contient l'appel Jaxon pour afficher la page correspondante.
La variable `call` n'est pas disponible dans le template `disabled`.

Pour personnaliser la pagination, il faut copier tous les templates vers un autre répertoire, et les modifier.
Ensuite, configurer le nouveau répertoire avec l'appel suivant.

```php
jaxon()->template()->pagination('/chemin/vers/le/repertoire/de/template');
```
