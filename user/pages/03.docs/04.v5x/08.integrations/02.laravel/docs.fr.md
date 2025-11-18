---
title: Intégration avec Laravel
menu: Laravel
template: jaxon
---

[L'extension Jaxon pour Laravel](https://github.com/jaxon-php/jaxon-laravel) s'installe avec `Composer`.

```bash
composer install jaxon-php/jaxon-laravel
```

La version `5.x` de l'extension est compatible avec toutes les versions du framework à partir de la `7.0`.

#### Les fonctions de l'extension

Elle bootstrappe la libairie à partir du fichier `config/jaxon.php`, et fournit toutes les [fonctions des extensions d'intégration](../about.html).

Elle fournit deux middlewares pour initialiser la librairie Jaxon, et crée la route pour traiter les requêtes Jaxon.
Elle fournit aussi des fonctions de proxy pour les fonctions de logs, des vues, d'injection de dépendances et de gestion des sessions.

#### Les directives Blade

Dans les vues Blade, les directives `jxnCss`, `jxnJs` et `jxnScript` insèrent les codes CSS et Javascript de Jaxon dans les templates.

```php
// resources/views/demo/index.blade.php

<!-- In page header -->
@jxnCss()
</head>

<body>
<!-- Page content here -->
</body>

<!-- In page footer -->
@jxnJs()

@jxnScript()
```

> **Note** Dans les exemples suivants, la variable de template `rqAppTest` prend comme valeur `rq(Demo\Ajax\App\AppTest::class)`.

La directive `jxnBind` attache un composant d'UI à un noeud du DOM, et `jxnHtml` y insère son code HTML.

```php
    <div class="col-md-12" @jxnBind($rqAppTest)>
        @jxnHtml($rqAppTest)
    </div>
```

La directive `jxnPagination` insère les [liens de pagination](../../ui-features/pagination.html) d'une fonction d'un composant dans un template.

```php
    <div class="col-md-12" @jxnPagination($rqAppTest)>
    </div>
```

La directive `jxnOn` lie un évènement sur un élément du DOM à un appel Javascript défini avec une `call factory`.

```php
    <select class="form-select"
        @jxnOn('change', $rqAppTest->setColor(jq()->val()))>
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
```

La directive `jxnClick` est un raccourci pour définir un gestionnaire pour l'évènement `click`.

```php
    <button type="button" class="btn btn-primary"
        @jxnClick($rqAppTest->sayHello(true))>Click me</button>
```

La directive `jxnEvent` définit un ensemble de gestionnaires d'évènements sur les enfants d'un élément du DOM, à l'aide de sélecteurs `jQuery`.

```php
    <div class="row" @jxnEvent([
        ['.app-color-choice', 'change', $rqAppTest->setColor(jq()->val())]
        ['.ext-color-choice', 'change', $rqExtTest->setColor(jq()->val())]
    ])>
        <div class="col-md-12">
            <select class="form-control app-color-choice">
                <option value="black" selected="selected">Black</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
            </select>
        </div>
        <div class="col-md-12">
            <select class="form-control ext-color-choice">
                <option value="black" selected="selected">Black</option>
                <option value="red">Red</option>
                <option value="green">Green</option>
                <option value="blue">Blue</option>
            </select>
        </div>
    </div>
```

La directive `jxnEvent` prend en paramètre un tableau dont chaque entrée est un tableau contenant un sélecteur `jQuery`, un évènement et une `call factory`.

#### L'application de démo

L'application de démo dans repo [https://github.com/jaxon-php/jaxon-demo-laravel](https://github.com/jaxon-php/jaxon-demo-laravel) intègre l'extension dans la version 9 de Laravel.

![Démo Laravel](/images/jaxon-demo-laravel.png)

Elle affiche dans une même page le formulaire utilisé dans [les exemples](https://github.com/jaxon-php/jaxon-examples), qui est construit ici avec des templates Blade, et une calculatrice implémentée dans un package et dont le code dans le repo [https://github.com/jaxon-php/jaxon-demo-calc](https://github.com/jaxon-php/jaxon-demo-calc).
