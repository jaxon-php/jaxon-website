---
title: La fabrique de requête (`Request Factory`)
menu: Request Factory
template: jaxon
---

La classe `Jaxon\Request\Factory\RequestFactory` permet de créer des requêtes vers les fonctions ou les méthodes exportées avec Jaxon.
La fonction globale `Jaxon\rq()` retourne une instance de cette classe, qui fournit une fonction `call()` pour créer la requête.
Elle sera souvent utilisée avec la fonction `Jaxon\pm()`, pour lui [ajouter des paramètres](../parameters/).

Par exemple, le code suivant utilise la `Request Factory` pour générer un appel à la méthode `setColor()` de la classe `HelloWorld`, en lui passant la valeur de la liste déroulante avec l'id `colorselect`.

```php
<div class="col-md-4 margin-vert-10">
    <select id="colorselect" name="colorselect"
            onchange="<?= Jaxon\rq('HelloWorld')->call('setColor', Jaxon\pm()->select('colorselect')) ?>">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

La `Request Factory` peut aussi être utilisée pour lier un appel à une fonction Jaxon à un évènement.

```php
use function Jaxon\pm;
use function Jaxon\rq;

public function myFunction()
{
    $response->setEvent('colorselect', 'onchange', rq('HelloWorld')->call('setColor', pm()->select('colorselect')));
    return $response;
}
```

Le préfixe configuré est automatiquement ajouté au code javascript généré.

#### Les appels conditionnels

La `Request Factory` fournit 3 fonctions pour vérifier une condition avant l'éxécution de la requête.

La fonction `when()` exécute la requête seulement si une condition est vraie.
Dans l'exemple suivant la requête est exécutée si l'utilisateur a coché la case avec l'id `accepted`.

```php
use function Jaxon\pm;
use function Jaxon\rq;

public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pm()->select('colorselect'))
        ->when(pm()->checked('accepted'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

La fonction `unless()` exécute la requête seulement si une condition est fausse.
Dans l'exemple suivant la requête est exécutée si l'utilisateur n'a pas coché la case avec l'id `refused`.

```php
use function Jaxon\rq;
use function Jaxon\pm;

public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pm()->select('colorselect'))
        ->unless(pm()->checked('refused'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

La fonction `confirm()` exécute la requête seulement si l'utilisateur répond oui à la question posée.

```php
use function Jaxon\rq;
use function Jaxon\pm;

public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pm()->select('colorselect'))
        ->confirm('Etes-vous sûr?');
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

Le contenu de la page web peut être inclus dans la question, en indiquant les positions entre accolades.

```php
use function Jaxon\pm;
use function Jaxon\rq;

public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pm()->select('colorselect'))
        ->confirm('Vous voulez du {1} ? Vraiment, {2} ?', pm()->select('colorselect'), pm()->html('username'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

L'ordre des paramètres dans dans le message peut être changé, ce qui permet par exemple de réaliser des traductions.

```php
use function Jaxon\pm;
use function Jaxon\rq;

public function myFunction()
{
    $request = rq('HelloWorld')->call('setColor', pm()->select('colorselect'))
        ->confirm('Bonjour {2}, vous voulez du {1} ?', pm()->select('colorselect'), pm()->html('username'));
    $response->setEvent('colorselect', 'onchange', $request);
    return $response;
}
```

Par défaut, le message de confirmation est affiché avec la fonction javascript `confirm()`.
Le plugin [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) permet de poser la question de confirmation avec d'autres librairies javascript.
