---
title: Intégration avec Symfony
menu: Symfony
template: jaxon
---

[L'extension Jaxon pour Symfony](https://github.com/jaxon-php/jaxon-symfony) s'installe avec `Composer`.

```bash
composer install jaxon-php/jaxon-symfony
```

La version `5.x` de l'extension est compatible avec toutes les versions du framework à partir de la `5.0`.

#### Les fonctions de l'extension

Elle bootstrappe la libairie à partir du fichier `config/packages/jaxon.yaml`, et fournit toutes les [fonctions des extensions d'intégration](../about.html).

Elle fournit un listener pour initialiser la librairie Jaxon, un fichier de configuration pour définir la route, et un controller pour traiter les requêtes Jaxon.
Elle fournit aussi des fonctions de proxy pour les fonctions de logs, des vues, d'injection de dépendances et de gestion des sessions.

#### Les fonctions Twig

Dans les vues Twig, les fonctions `jxnCss`, `jxnJs` et `jxnScript` insèrent les codes CSS et Javascript de Jaxon dans les templates.

```php
{% raw %}
// resources/views/demo/index.blade.php

<!-- In page header -->
{{ jxnCss() }}
</head>

<body>
<!-- Page content here -->
</body>

<!-- In page footer -->
{{ jxnJs() }}

{{ jxnScript() }}
{% endraw %}
```

> **Note** Dans les exemples suivants, la variable de template `rqAppTest` prend comme valeur `rq(Demo\Ajax\App\AppTest::class)`.

La fonction `jxnBind` attache un composant d'UI à un noeud du DOM, et `jxnHtml` y insère son code HTML.

```php
{% raw %}
    <div class="col-md-12" {{ jxnBind(rqAppTest) }}>
        {{ jxnHtml(rqAppTest) }}
    </div>
{% endraw %}
```

La fonction `jxnPagination` insère les [liens de pagination](../../ui-features/pagination.html) d'une fonction d'un composant dans un template.

```php
{% raw %}
    <div class="col-md-12" {{ jxnPagination(rqAppTest) }}>
    </div>
{% endraw %}
```

La fonction `jxnOn` lie un évènement sur un élément du DOM à un appel Javascript défini avec une `call factory`.

```php
{% raw %}
    <select class="form-select"
        {{ jxnOn('change', rqAppTest.setColor(jq().val())) }}>
        <option value="black" selected="selected">Black</option>
        <option value="red">Red</option>
        <option value="green">Green</option>
        <option value="blue">Blue</option>
    </select>
{% endraw %}
```

La fonction `jxnClick` est un raccourci pour définir un gestionnaire pour l'évènement `click`.

```php
{% raw %}
    <button type="button" class="btn btn-primary"
        {{ jxnClick(rqAppTest.sayHello(true)) }}>Click me</button>
{% endraw %}
```

La fonction `jxnEvent` définit un ensemble de gestionnaires d'évènements sur les enfants d'un élément du DOM, à l'aide de sélecteurs `jQuery`.

```php
{% raw %}
    <div class="row" {{ jxnEvent([
        ['.app-color-choice', 'change', rqAppTest.setColor(jq().val())]
        ['.ext-color-choice', 'change', rqExtTest.setColor(jq().val())]
    ]) }}>
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
{% endraw %}
```

La fonction `jxnEvent` prend en paramètre un tableau dont chaque entrée est un tableau contenant un sélecteur `jQuery`, un évènement et une `call factory`.

Les fonctions `jxnBind`, `jxnHtml`, `jxnPagination`, `jxnOn`, `jxnClick` et `jxnEvent`sont également définies comme des filtres Twig.
Elles peuvent donc être appelées avec une syntaxe différente.

```php
{% raw %}
    <div class="col-md-12" {{ rqAppTest|jxnBind }}>
        {{ rqAppTest|jxnHtml }}
    </div>
{% endraw %}
```

Enfin, les [fonctions des call factories](../../ui-features/call-factories.html) `jq`, `je`, `jo` et `rq` sont également définies en tant que fonctions Twig.

#### L'application de démo

L'application de démo dans repo [https://github.com/jaxon-php/jaxon-demo-symfony](https://github.com/jaxon-php/jaxon-demo-symfony) intègre l'extension dans la version 6.4 de Symfony.

![Démo Symfony](/images/jaxon-demo-symfony.png)

Elle affiche dans une même page le formulaire utilisé dans [les exemples](https://github.com/jaxon-php/jaxon-examples), qui est construit ici avec des templates Twig, et une calculatrice implémentée dans un package et dont le code dans le repo [https://github.com/jaxon-php/jaxon-demo-calc](https://github.com/jaxon-php/jaxon-demo-calc).
