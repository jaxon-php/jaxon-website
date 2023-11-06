---
title: La fabrique de requête
menu: Fabrique de requête
template: jaxon
---

La classe `Jaxon\Request\Factory` permet de créer des requêtes vers les fonctions ou les méthodes exportées avec Jaxon.
La fonction globale `rq()` retourne une instance de cette classe, qui fournit une fonction `call()` pour créer la requête, et un ensemble d'autres fonctions pour lui passer des éléments de la page HTML en paramètre.

Par exemple, le code suivant utilise la fabrique de requête pour générer un appel à la méthode `setColor()` de la classe `HelloWorld`, en lui passant la valeur de la liste déroulante avec l'id `colorselect`.

```php
<div class="col-md-4 margin-vert-10">
    <select id="colorselect" name="colorselect"
            onchange="<?php echo rq()->call('HelloWorld.setColor', rq()->select('colorselect')) ?>">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

La fabrique de requête peut aussi être utilisée pour lier un appel à une fonction Jaxon à un évènement.

```php
public function myFunction()
{
    $response->setEvent('colorselect', 'onchange', rq()->call('HelloWorld.setColor', rq()->select('colorselect')));
    return $response;
}
```

Le préfixe configuré est automatiquement ajouté au code javascript généré.

Les méthodes suivantes sont utilisées pour lire le contenu de la page.

- form($sFormId): retourne les valeurs dans le formulaire avec l'id donné.
- input($sInputId): retourne la valeur de la zone de texte avec l'id donné.
- checked($sInputId): retourne la valeur de la case à cocher avec l'id donné.
- select($sInputId): retourne la valeur de la liste déroulante avec l'id donné.
- html($sElementId): retourne le texte de l'élément HTML avec l'id donné.
- js($sValue): retourne une variable ou un appel de fonction javascript.

La liste complète des fonctions de la classe `Jaxon\Request\Factory` est [documentée ici](/api/Jaxon/Request/Factory.html).

#### Le trait de la fabrique de requête

Le trait `Jaxon\Request\Traits\Factory` ajoute aux classes Jaxon une fonction `call()` qui simplifie la création des requêtes Jaxon vers leurs méthodes. Elle prend en paramètre le nom d'une méthode, et lui ajoute automatiquement le nom de la classe en javascript.

```php
class MyClass
{
    use \Jaxon\Request\Traits\Factory;

    public function myMethod($color)
    {
        $response->onClick('button-ok', $this->call('myMethod', rq()->select('colorselect')));
        return $response;
    }
}
```

#### Les appels conditionnels

La fabrique de requête fournit 3 fonctions pour vérifier une condition avant l'éxécution de la requête.

La fonction `when()` exécute la requête seulement si une condition est vraie.
Dans l'exemple suivant la requête est exécutée si l'utilisateur a coché la case avec l'id `accepted`.

```php
public function myFunction()
{
    $request = rq()->call('HelloWorld.setColor', rq()->select('colorselect'))
        ->when(rq()->checked('accepted'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

La fonction `unless()` exécute la requête seulement si une condition est fausse.
Dans l'exemple suivant la requête est exécutée si l'utilisateur n'a pas coché la case avec l'id `refused`.

```php
public function myFunction()
{
    $request = rq()->call('HelloWorld.setColor', rq()->select('colorselect'))
        ->unless(rq()->checked('refused'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

La fonction `confirm()` exécute la requête seulement si l'utilisateur répond oui à la question posée.

```php
public function myFunction()
{
    $request = rq()->call('HelloWorld.setColor', rq()->select('colorselect'))
        ->confirm('Etes-vous sûr?');
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

Le contenu de la page web peut être inclus dans la question, en indiquant les positions entre accolades.

```php
public function myFunction()
{
    $request = rq()->call('HelloWorld.setColor', rq()->select('colorselect'))
        ->confirm('Vous voulez du {1} ? Vraiment, {2} ?', rq()->select('colorselect'), rq()->html('username'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

L'ordre des paramètres dans dans le message peut être changé, ce qui permet par exemple de prendre en compte les traductions.

```php
public function myFunction()
{
    $request = rq()->call('HelloWorld.setColor', rq()->select('colorselect'))
        ->confirm('Bonjour {2}, vous voulez du {1} ?', rq()->select('colorselect'), rq()->html('username'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

Par défaut, le message de confirmation est affiché avec la fonction javascript `confirm()`.
Le plugin [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) permet de poser la question de confirmation avec d'autres librairies javascript.
