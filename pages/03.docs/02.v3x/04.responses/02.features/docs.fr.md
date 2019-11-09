---
title: Fonctionnalités de la classe Response
menu: Fonctionnalités
template: jaxon
---

Les fonctions Jaxon retournent un objet de la classe `Jaxon\Response\Response`, qui contient une liste de commandes à exécuter dans le navigateur.
Ces commandes peuvent réaliser 3 types d'opérations dans une page web.

- Modifier le contenu de la page
- Modifier la présentation de la page avec CSS
- Exécuter du code javascript dans la page

#### Modifier le contenu et le style de la page

Les fonctions suivantes servent à modifier le contenu ou le style d'une page web.

```php
// Affecter la valeur spécifiée à un attribut d'un élément donné
assign(string $sTarget, string $sAttribute, string $sData)

// Ajouter la valeur spécifiée à la fin d'un attribut d'un élément donné
append(string $sTarget, string $sAttribute, string $sData)

// Ajouter la valeur spécifiée au début d'un attribut d'un élément donné
prepend(string $sTarget, string $sAttribute, string $sData)

// Remplace la valeur spécifiée par une autre dans un attribut d'un élément donné
replace(string $sTarget, string $sAttribute, string $sSearch, string $sData)

// Effacer la valeur d'un attribut d'un élément donné
clear(string $sTarget, string $sAttribute)
```

Pour modifier le contenu, le paramètre `$sAttribute` prend la valeur `innerHTML` ou `outerHTML`.
Par exemple, le code suivant affecte un texte au bloc HTML avec l'id `message-id`.

```php
$response->assign('message-id', 'innerHTML', 'Jaxon is cool');
```

Pour modifier le style, le paramètre `$sAttribute` prend la valeur `style.` suivi de l'attribut CSS à modifier.
Par exemple, le code suivant définit la couleur du texte du bloc HTML avec l'id `message-id`.

```php
$response->assign('message-id', 'style.color', 'blue');
```

Les fonctions suivantes ajoutent ou suppriment un bloc de contenu dans une page web.

```php
// Créer un nouvel élément dans le document
create(string $sParent, string $sTag, string $sId)

// Insérer un nouvel élément avant l'élément spécifié
insert(string $sBefore, string $sTag, string $sId)

// Insérer un nouvel élément après l'élément spécifié
insertAfter(string $sAfter, string $sTag, string $sId)

// Supprimer l'élément spécifié du document
remove(string $sTarget)
```

#### Exécuter du code javascript dans la page

Ces fonctions permettent soit d'exécuter directement du code javascript, soit de le lier à un évènement sur la page.

```php
// Afficher un message d'alerte
alert(string $sMessage)

// Exécuter le code javascript spécifié
script(string $sJsCode)

// Appeler la fonction javascript spécifiée avec les paramètres (optionnels) donnés
call(string $sFunction)

// Définir un gestionnaire d'évènement sur l'élément spécifié
setEvent(string $sTarget, string $sEvent, string $sScript)

// Définir un gestionnaire pour l'évènement "onclick" sur l'élément spécifié
onClick(string $sTarget, string $sScript)

// Installer un gestionnaire d'évènement sur l'élément spécifié
addHandler(string $sTarget, string $sEvent, string $sHandler)

// Supprimer un gestionnaire d'évènement sur l'élément spécifié
removeHandler(string $sTarget, string $sEvent, string $sHandler)
```

Par exemple, le code suivant exécute une fonction Jaxon lorsque l'utilisateur clique sur le bouton.

```php
$response->onClick('btn-set-color', rq('MyClass')->call('myMethod', pr()->select('colorselect')));
```

Bien que la classe `Jaxon\Response\Response` implémente un riche ensemble de fonctions, il est possible de lui en ajouter à l'aide de [plugins](../plugins).
