---
title: Fonctionnalités de la classe Response
menu: Les réponses
template: jaxon
---

Les fonctions Jaxon utilisent un objet de la classe `Jaxon\Response\Response`, pour définir une liste de commandes à exécuter dans le navigateur.

Ces commandes peuvent réaliser 3 types d'opérations dans une page web.
- Modifier le contenu de la page
- Modifier la présentation de la page avec CSS
- Exécuter du code javascript dans la page

Bien que la classe `Jaxon\Response\Response` implémente un riche ensemble de fonctions, il est possible de lui en ajouter à l'aide de [plugins](../../extensions/response.html).

#### Modifier le contenu et le style de la page

Les fonctions suivantes servent à modifier le contenu ou le style d'une page web.

Les fonctions de ce groupe, à l'exception de `bind()`, sont également présentes dans la classe `Jaxon\Response\NodeResponse`, mais sans le paramètre `string $sTarget`.

```php
// Affecter la valeur spécifiée à un attribut d'un élément donné
assign(string $sTarget, string $sAttribute, string $sValue)

// Affecter le contenu HTML spécifié à un élément donné
html(string $sTarget, string $sValue)

// Affecter la valeur spécifiée à un attribut CSS d'un élément donné
style(string $sTarget, string $sCssAttribute, string $sValue)

// Ajouter la valeur spécifiée à la fin d'un attribut d'un élément donné
append(string $sTarget, string $sAttribute, string $sValue)

// Ajouter la valeur spécifiée au début d'un attribut d'un élément donné
prepend(string $sTarget, string $sAttribute, string $sValue)

// Remplace la valeur spécifiée par une autre dans un attribut d'un élément donné
replace(string $sTarget, string $sAttribute, string $sSearch, string $sValue)

// Effacer la valeur d'un attribut d'un élément donné
clear(string $sTarget, string $sAttribute)

// Supprimer l'élément spécifié du document
remove(string $sTarget)

// Attacher un composant à un élément donné
bind(string $sTarget, Jaxon\Script\JxnCall $xCall, string $sItem = '')
```

Pour modifier le contenu, le paramètre `$sAttribute` prend la valeur `innerHTML` ou `outerHTML`.

```php
$response->assign('message-id', 'innerHTML', 'Jaxon is cool');
```

Pour modifier le style, le paramètre `$sCssAttribute` prend pour valeur l'attribut CSS à modifier.

```php
$response->style('message-id', 'color', 'blue');
```

#### Exécuter du code javascript dans la page

Ces fonctions permettent soit d'exécuter directement du code javascript, soit de le lier à un évènement sur la page.

Les fonctions de ce groupe sont également présentes dans la classe `Jaxon\Response\NodeResponse`.

```php
// Appeler la fonction javascript spécifiée avec les paramètres (optionnels) donnés
call(string $sFunction)

// Exécuter l'expression json spécifiée
exec(JsExpr $xJsExpr)

// Poser une question à l'utilisateur avec une fenêtre de type [ok] [cancel]
confirm(Closure $fConfirm, string $sQuestion, array $aArgs = [])

// Afficher un message d'alerte
alert(string $sMessage, array $aArgs = [])

// Afficher un message de debug
debug(string $sMessage)

// Rediriger le navigateur vers l'URL spécifiée
redirect(string $sURL, int $nDelay = 0)

// Mettre l'exécution des commandes de réponse en pause
sleep(int $tenths)
```

La fonction `confirm()` prend en paramètre une callback et une question à poser à l'utilisateur.
La callback prend en paramètre un objet `Jaxon\Response\Response`, et les commandes ajoutées à cet objet ne seront exécutées que si l'utilisateur répond oui à la question.

```php
public function doThis()
{
    $this->response()->confirm(function($response) {
        $response->style('element-id', 'color', 'blue');
    }, 'Set the element color to blue?');
}
```

#### Fonctions dépréciées

Deux groupes de fonctions ont été dépréciées: celles qui ajoutent ou suppriment un bloc de contenu dans une page web, et celles qui lient des fonctions Javascript à un évènement sur la page.

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

```php
// Définir un gestionnaire d'évènement sur l'élément spécifié
setEvent(string $sTarget, string $sEvent, string $sScript)

// Définir un gestionnaire pour l'évènement "onclick" sur l'élément spécifié
onClick(string $sTarget, string $sScript)

// Installer un gestionnaire d'évènement sur l'élément spécifié
addHandler(string $sTarget, string $sEvent, string $sHandler)

// Supprimer un gestionnaire d'évènement sur l'élément spécifié
removeHandler(string $sTarget, string $sEvent, string $sHandler)
```

Les fonctions de [templates](../../ui-features/templates.html) doivent être utilisées à la place.
