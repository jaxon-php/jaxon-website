---
title: La fabrique de paramètre (`Request Factory`)
menu: Parameter Factory
template: jaxon
published: true
---

En plus de la `Request Factory`, Jaxon fournit également une `Parameter Factory`, qui permet de définir les paramètres à passer aux appels en Ajax vers les fonctions ou les méthodes exportées.
Elle sera utilisée lorsque la valeur des paramètres provient de la page web, c'est-à-dire soit du HTML (par exemple un formulaire), soit du javascript.

#### La classe `Parameter Factory`

La `Parameter Factory` est implémentée par la classe `Jaxon\Request\Factory\ParameterFactory`.
La fonction globale `Jaxon\pm()` retourne une instance de cette classe, qui fournit un ensemble d'autres fonctions pour passer des éléments de la page HTML en paramètre à une requête Ajax.

Les méthodes suivantes sont utilisées pour lire le contenu de la page.

- `pm()->form($sFormId)`: retourne les valeurs dans le formulaire avec l'id donné.
- `pm()->input($sInputId)`: retourne la valeur de la zone de texte avec l'id donné.
- `pm()->checked($sInputId)`: retourne la valeur de la case à cocher avec l'id donné.
- `pm()->select($sInputId)`: retourne la valeur de la liste déroulante avec l'id donné.
- `pm()->html($sElementId)`: retourne le texte de l'élément HTML avec l'id donné.
- `pm()->js($sValue)`: retourne une variable ou un appel de fonction javascript.

Etant donné le code HTML ci-dessous,

```html
<div class="col-md-4 margin-vert-10">
    <select id="colorselect" name="colorselect">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

Le code PHP suivant va lier l'appel à une fonction Jaxon à l'évènement `onchange` du composant HTML select.

```php
use function Jaxon\pm;
use function Jaxon\rq;

public function myFunction()
{
    $response->setEvent('colorselect', 'onchange', rq('HelloWorld')->call('setColor', pm()->select('colorselect')));
    return $response;
}
```
