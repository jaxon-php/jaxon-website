---
title: Les fonctions de template
menu: Les templates
template: jaxon
---

La librairie Jaxon propose des fonctions à utiliser dans les templates, pour insérer les codes Javascript et CSS générés dans les templates, et attacher les [composants](../../components/node-components.html) et les gestionnaires d'évènements aux éléments de la page.

Parmi ces fonctions, celles fournies par l'objet `attr()` ajoutent des attributs spécifiques à Jaxon à ces éléments, qui seront traités par la librairie Javascript dans le navigateur, pour mettre en place les fonctionnalités correspondantes.

#### Inclure le code de Jaxon dans la page web

Les fonctions `css()`, `js()` et `script()` de l'objet `jaxon()` retournent les codes à inclure dans une page web pour faire fonctionner la librairie.

```php
<html>
<head>

<?= jaxon()->css() ?>
</head>
<body>


</body>

<?= jaxon()->js() ?>
<?= jaxon()->script() ?>
</html>
```

#### Attacher un composant à un élément

Jaxon fournit des fonctions pour attacher un [composant](../../components/node-components.html) à un element d'une page web et gérer dynamiquement son contenu.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
</div>
```

Si un même composant doit être affiché plusieurs fois dans une page, alors il faut ajouter un identifiant unique à chaque instance.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class), 'first') ?>>
</div>

<div class="row" <?= attr()->bind(rq(UiComponent::class), 'second') ?>>
</div>
```

Le code HTML d'un composant peut être inséré directement dans le template.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
    <?= cl(UiComponent::class)->html() ?>
</div>
```

#### Attacher un gestionnaire d'évènement à un élément

La librairie Jaxon fournit des fonctions pour attacher un gestionnaire d'évènement à un ou plusieurs éléments d'une page.

La fonction `on()` définit un gestionnaire d'évènement sur un élément.
Elle prend en paramètres le nom de l'évènement et la fonction à appeler, définie à l'aide de la [call factory](../call-factories.html).

```php
<select class="form-select" <?= attr()->on('change', rq(FuncComponent::class)->doThat()) ?>>
    <option value="black" selected="selected">Black</option>
    <option value="red">Red</option>
    <option value="green">Green</option>
    <option value="blue">Blue</option>
</select>
```

La fonction `attr()->click()` est un raccourci pour définir un gestionnaire pour l'évènement `click`.

```php
<button type="button" <?= attr()->click(rq(FuncComponent::class)->doThat()) ?>>CLICK ME</button>
```

L'usage de la fonction `rq()` est décrite dans la page des [Call factories](../call-factories.html).

#### Utiliser un sélecteur

Il est possible de définir un gestionnaire d'évènement sur un ensemble d'éléments enfants choisis à l'aide d'un sélecteur, sur le modèle de [jQuery](https://jquery.com).

```php
<div <?= attr()->select('.color-choice')->on('change', rq(FuncComponent::class)->doThat()) ?>>
    <select class="form-control color-choice">
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
</div>
```

Dans ce cas, avant l'appel de la fonction `on()`, il y a un appel à la fonction `select()` qui prend en paramètre un sélecteur [jQuery](https://jquery.com).

Le sélecteur [jQuery](https://jquery.com) sera appliqué uniquement aux éléments enfants de celui où est défini le gestionnaire d'évènement.

#### Définitions multiples

Enfin, il est également possible de définir plusieurs gestionnaires d'évènement sur les éléments contenus dans un même parent, en chaînant les appels aux fonctions `select()` et `on()`.

```php
<div class="row" <?= attr()
    ->select('.first-choice')->on('change', rq(FuncComponent::class)->doThis())
    ->select('.second-choice')->on('change', rq(FuncComponent::class)->doThat()) ?>>
    <div class="col-md-12">
        <select class="form-control first-choice">
            <option value="black" selected="selected">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>
    </div>

    <div class="col-md-12">
        <select class="form-control second-choice">
            <option value="black" selected="selected">Black</option>
            <option value="red">Red</option>
            <option value="green">Green</option>
            <option value="blue">Blue</option>
        </select>
    </div>
</div>
```

De même, les sélecteurs [jQuery](https://jquery.com) seront appliqués uniquement aux éléments enfants de celui où est défini le gestionnaire d'évènement.
