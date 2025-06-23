---
title: Les call factories
menu: Les call factories
template: jaxon
---

Une `call factory` est une classe PHP qui sert à générer des appels en Javascript qui vont être exécutés dans le navigateur.
Elle sera utilisé pour insérer du code Javascript dans les templates ou définir des gestionnaires d'évènement dans les templates et les composants.

Les `call factories` ont une syntaxe `fluent`. Elles convertissent les appels en PHP qu'elles reçoivent en appels aux fonctions Javascript du même nom, avec les mêmes paramètres.

Ces paramètres pouvant eux-mêmes être définis avec des `call factories`, cela permet, en programmant sur le serveur, de passer n'importe quelle valeur présente dans la page web en paramètre à des appels Javascript.

Différentes `call factories` existent pour générer des appels vers les classes et fonctions exportées, vers les autres fonctions Javascript, et vers les sélecteurs de type jQuery ou Javascript.

#### Les classes et fonctions exportées

La fonction globale `rq()` crée une `call factory` pour la classe exportée dont elle a reçu le nom en paramètre.
Un appel sur cette factory génère le code du même appel en Javascript, qui peut donc être utilisé dans un template par exemple pour définir un gestionnaire d'évènement.

```php
<button type="button" <?= attr()
    ->click(rq(FuncComponent::class)->doThat()) ?>>Click me</button>
```

Sans paramètre, la fonction `rq()` renvoie une `call factory` pour créer des appels vers les fonctions exportées.

```php
<button type="button" <?= attr()->click(rq()->hello_world()) ?>>Click me</button>
```

Dans une classe de [composant](../../components/func-components.html), la méthode `rq()`, appelée sans paramètre, retourne une `call factory` pour la classe courante.
Si elle reçoit une classe en paramètre, elle retourne une `call factory` pour cette classe.

```php
class FuncComponent
{
    public function show()
    {
        $html = $this->view()->render('users::path/to/view', [
            'clickHandler' => $this->rq()->doThat(), 
        ]);
    }

    public function doThat()
    {
        // Do something
    }
}
```

```php
<button type="button" <?= attr()->click($this->clickHandler) ?>>Click me</button>
```

La fonction `rq()` et la méthode `rq()` ajoutent automatiquement le préfixe configuré pour les classes ou les fonctions exportées au code javascript généré.

#### Les fonctions Javascript

La fonction globale `jo()` crée une `call factory` pour un objet Javascript, qui doit déjà exister dans l'application côté client.

Un appel sur cette factory génère le code d'appel de la même fonction en Javascript, qui peut donc être utilisé dans un template par exemple pour définir un gestionnaire d'évènement.

```php
// Appeler la fonction Javascript Example.Embedded.doSomething().
<button type="button" <?= attr()
    ->click(jo('Example.Embedded')->doSomething()) ?>>Click me</button>
```

Appelée sans paramètre, la fonction `jo()` renvoie une `call factory` vers l'objet Javascript `window`.
Elle peut donc servir à générer des appels vers des fonctions globales Javascript, ou à accéder à des variables globales.

```php
// Appeler la fonction Javascript alert().
<button type="button" <?= attr()
    ->click(jo()->alert('Button clicked!!')) ?>>Click me</button>
```

Cette `call factory` peut recevoir des appels vers ses propriétés, qui peuvent même être chaînés.

```php
// Javascript console.log()
<button type="button" <?= attr()
    ->click(jo()->console->log('Button clicked!!')) ?>>Click me</button>
// Idem que jo('console')->log('Button clicked!!')
```

Dans l'objet [Response](../../features/responses.html), la méthode `jo()` ajoute l'appel à la liste des commandes à exécuter dans le navigateur.

```php
class FuncComponent
{
    public function doThat()
    {
        $this->response->jo('Example.Embedded')->doSomething();
    }
}
```

#### Les sélecteurs

La fonction globale `jq()` crée une `call factory` pour un sélecteur jQuery.
Elle prend en paramètre un [sélecteur jQuery](https://api.jquery.com/category/selectors/).

Un appel sur cette factory génère le code Javascript pour lire ou affecter des valeurs sur les éléments sélectionnés, ou bien pour définir des gestionnaires d'évènement.
Elle sera souvent utilisée avec l'objet [Response](../../features/responses.html), pour ajouter l'appel à la liste des commandes à exécuter dans le navigateur.

```php
class FuncComponent
{
    public function show()
    {
        $this->response->jq('#button-id')
            ->click($this->rq()->doThat(jq('#button-id')->attr('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

Appelée sans paramètre, cette `call factory` retourne l'objet jQuery `$(this)`.
Il peut par exemple être passé en paramètre d'un gestionnaire d'évènement.

```php
class FuncComponent
{
    public function show()
    {
        $this->response->jq('#button-id')
            ->click($this->rq()->doThat(jq()->attr('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

La fonction globale `je()` crée une `call factory` pour un sélecteur Javascript correspondant à la fonction [getElementById()](https://developer.mozilla.org/en-US/docs/Web/API/Document/getElementById).
Elle prend en paramètre l'id de l'élément à retrouver.

Un appel sur cette factory génère le code Javascript pour lire ou affecter des valeurs sur l'élément sélectionné, ou bien pour définir des gestionnaires d'évènement.
Elle sera souvent utilisée avec l'objet [Response](../../features/responses.html), pour ajouter l'appel à la liste des commandes à exécuter dans le navigateur.

```php
class FuncComponent
{
    public function show()
    {
        $this->response->je('button-id')->addEventListener('click',
            $this->rq()->doThat(je('button-id')->getAttribute('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

Appelée sans paramètre, cette `call factory` retourne l'objet Javascript `this`.
Il peut par exemple être passé en paramètre d'un gestionnaire d'évènement.

```php
class FuncComponent
{
    public function show()
    {
        $this->response->je('button-id')->addEventListener('click',
            $this->rq()->doThat(je()->getAttribute('data-label')));
    }

    public function doThat(string $buttonLabel)
    {
        // Do something
    }
}
```

#### Helpers

La `call factory` créée par la fonction globale `je()` fournit aussi des helpers pour lire des valeurs dans une page ou un formulaire web.

- `je($sElementId)->rd()->form()`: retourne les valeurs dans le formulaire avec l'id donné.
- `je($sElementId)->rd()->input()`: retourne la valeur de la zone de texte avec l'id donné.
- `je($sElementId)->rd()->checked()`: retourne la valeur de la case à cocher avec l'id donné.
- `je($sElementId)->rd()->select()`: retourne la valeur de la liste déroulante avec l'id donné.
- `je($sElementId)->rd()->html()`: retourne le texte de l'élément HTML avec l'id donné.
- `je()->rd()->page()`: retourne le numéro de page courant.

#### Les appels conditionnels

Les `call factories` fournissent des fonctions pour vérifier une condition avant l'éxécution de l'appel.

La fonction `confirm()` exécute l'appel seulement si l'utilisateur répond oui à la question posée.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->confirm('Etes-vous sûr ?')) ?>>Click me</button>
```

Les questions sont affichées avec les [fonctions de dialogues](../dialogs.html), et des valeurs issues du contenu de la page web peuvent être incluses dans la question, en indiquant les positions entre accolades.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->confirm('Vous voulez du {1} ? Vraiment, {2} ?',
        je('colorselect')->text, je('username')->innerHtml)) ?>>Click me</button>
```

L'ordre des paramètres dans dans le message peut être différent, ce qui est utile par exemple pour les traductions.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->confirm('Bonjour {2}, vous voulez du {1} ?',
        je('colorselect')->text, je('username')->innerHtml)) ?>>Click me</button>
```

La fonction `when()` exécute l'appel seulement si une condition est vraie.
Dans l'exemple suivant l'appel est exécuté si l'utilisateur a coché la case avec l'id `accepted`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->when(je('accepted')->checked)) ?>>Click me</button>
```

La fonction `unless()` exécute l'appel seulement si une condition est fausse.
Dans l'exemple suivant l'appel est exécuté si l'utilisateur n'a pas coché la case avec l'id `refused`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->unless(je('refused')->checked)) ?>>Click me</button>
```

Il est également possible d'utiliser des fonctions de comparaison.
Leurs noms commencent par un `if`, et elles acceptent deux paramètres qui peuvent chacune être une constante ou un appel à une `call factory`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->ifeq(je('accepted')->checked, true)) ?>>Click me</button>
```

Les fonctions suivantes sont disponibles.

```php
    public function ifeq($xValue1, $xValue2);
    public function ifteq($xValue1, $xValue2);
    public function ifne($xValue1, $xValue2);
    public function ifnte($xValue1, $xValue2);
    public function ifgt($xValue1, $xValue2);
    public function ifge($xValue1, $xValue2);
    public function iflt($xValue1, $xValue2);
    public function ifle($xValue1, $xValue2);
```

Enfin, les fonctions de type `else` permettent d'afficher un message à l'écran lorsque la condition requise n'a pas été vérifiée.
De même que pour la confirmation, les messages sont affichés avec les [fonctions de dialogues](../dialogs.html), et des valeurs issues du contenu de la page web peuvent être incluses dans le message.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)
    ->doThat()
    ->when(je('accepted')->checked))
    ->elseShow('Hi {1}, vous devez cocher la case Accepter',
        je('username')->innerHtml)) ?>>Click me</button>
```

Les fonctions suivantes sont disponibles.

```php
    public function elseShow(string $sMessage, ...$aArgs);
    public function elseInfo(string $sMessage, ...$aArgs);
    public function elseSuccess(string $sMessage, ...$aArgs);
    public function elseWarning(string $sMessage, ...$aArgs);
    public function elseError(string $sMessage, ...$aArgs);
```
