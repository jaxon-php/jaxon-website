---
title: 'Introduction à Jaxon'
date: '10-05-2020 07:00'
media:
    images:
        - javier-garcia-chavez-unsplash.jpg
taxonomy:
    category:
        - blog
    tag:
        - php
        - javascript
        - ajax
---

Jaxon est un fork de la [librairie PHP Xajax](https://github.com/Xajax/Xajax), qui permet de créer des [applications Ajax avec PHP](/features/operation/lifecycle.html). Elle exporte des classes PHP vers Javascript, qui peuvent alors être appelées depuis un navigateur.
Elle fournit ensuite des fonctions pour définir le contenu et la présentation d'une page web dans ces classes. Au final, avec un appel javascript on peut exécuter un ensemble complexes d'actons sur une page web, définies en PHP sur le serveur.

Malheureusement, le développement de Xajax s'est arrêté en 2012, peu après la sortie de la version 0.6.
En juillet 2016, la version 1.0.0 de Jaxon est sortie. Elle reprenait les principales fonctions de Xajax, mais avec un code entièrement ré-écrit. Elle est séparée en un [package javascript](https://github.com/jaxon-php/jaxon-js), un [package PHP principal](https://github.com/jaxon-php/jaxon-core), et plusieurs extensions.

La dernière version stable de la librairie Jaxon est la `3.2.1`.

#### Les fonctions de Jaxon

[La version 3 de Jaxon](/docs/v3x.html) a mis l'accent sur l'extensibilité, et une configuration avancée.
Un nouveau type de plugin a été introduit: [les packages](/docs/v3x/plugins/packages.html), et il est désormais possible de démarrer la librairie à partir [d'un fichier de configuration unique](/docs/v3x/advanced/bootstrap.html).
Autre nouveauté importante, il n'est plus nécessaire d'instancier les [classes Jaxon](/docs/v3x/registrations/classes.html) lorsqu'elles sont enregistrées dans la librairie.

Les autres fonctionnalités ajoutées dans les versions précédentes sont toujours présentes: exporter des répertoires et des namespaces, envoyer des fichiers, générer des requêtes ajax ou de la pagination, etc.

#### Les extensions de Jaxon

La librairie Jaxon fournit 3 types d'extensions.

[Les plugins de réponse](/docs/v3x/plugins/response.html) étendent l'objet `Jaxon\Response\Response`, et ajoutent de nouvelles fonctions dans une page web, telles que les notifications ou l'affichage de graphes.

[Les plugins d'intégration](/docs/v3x/plugins/frameworks.html) simplifient l'usage de Jaxon avec les principaux frameworks PHP, et fournissent des API unifiées pour des fonctions telles que la gestion des vues ou des sessions.

[Les packages](/docs/v3x/plugins/packages.html) fournissent un ensemble complet de fonctions frontend et backend basées sur Jaxon, et accessibles à partir d'une page dédiée d'une application.

#### Un exemple simple

Pour illustrer son fonctionnement, dans l'exemple suivant on va créer un simple calculateur pour nombres entiers avec Jaxon et le framework Laravel. Il nécessite d'installer Laravel et les packages [jaxon-core](https://github.com/jaxon-php/jaxon-core), [jaxon-laravel](https://github.com/jaxon-php/jaxon-laravel), et [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs).

Les classes Jaxon seront placées dans le répertoire `app/Ajax`, qui dans Laravel correspond au namespace `App\Ajax`.

Voici la configuration correspondante, à placer dans le fichier `config/jaxon.php`.

```php
return [
    'app' => [
        'directories' => [
            app_path('Ajax') => [
                'namespace' => '\\App\\Ajax',
                'autoload' => false,
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'app' => [
                'export' => false,
                'minify' => false,
            ],
        ],
        'dialogs' => [
            'default' => [
                'message' => 'toastr',
            ],
            'toastr' => [
                'options' => [
                    'closeButton' => true,
                    'positionClass' => 'toast-top-center'
                ],
            ],
        ],
    ],
];
```

Le répertoire et le namespace des classes Jaxon sont déclarés dans la section `app.directories`. Le paramètre `autoload` a la valeur `false` car l'autoloading de ce répertoire est déjà géré par Laravel.
Les paramètres de la section `lib.dialogs` indiquent que les notifications seront affichées avec la librairie [Toastr](https://codeseven.github.io/toastr/).

Voici le code de la classe `Calculator`, à placer dans le fichier `app/Ajax/Calculator.php`.

```php
namespace App\Ajax;

use Jaxon\CallableClass;

class Calculator extends CallableClass
{
    public function calculate($firstOperand, $secondOperand, $operation)
    {
        $firstOperand = intval($firstOperand);
        $secondOperand = intval($secondOperand);
        $result = '';
        switch($operation)
        {
        case 'a':
            $result = $firstOperand + $secondOperand;
            break;
        case 's':
            $result = $firstOperand - $secondOperand;
            break;
        case 'm':
            $result = $firstOperand * $secondOperand;
            break;
        case 'd':
            if($secondOperand == 0)
            {
                $this->response->dialog->error('Division par zéro impossible.', 'Erreur');
                return;
            }
            $result = $firstOperand / $secondOperand;
            break;
        default:
            $this->response->dialog->error("Opération '$operation' non supportée.", 'Erreur');
            return;
        }

        $this->response->assign('result', 'innerHTML', "$result");
        return $this->response;
    }
}
```

La fonction `calculate()` sera appelée depuis le navigateur.
L'appel à `$this->response->dialog->error()` utilise le plugin `jaxon-dialogs` pour afficher un message d'erreur à l'écran.
L'appel à `$this->response->assign()` affiche le résultat dans l'élément HTML dont la propriété `id` a la valeur `result`.

Le contrôleur Laravel ci-dessous affiche la page.

```php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Ajax\Calculator;
use Jaxon\Laravel\Jaxon;

class DemoController extends Controller
{
    public function index(Jaxon $jaxon)
    {
        // Requête Jaxon vers la classe Calculator
        $calculatorRequest = $jaxon->request(Calculator::class);
        // Appel Ajax vers une méthode de la classe Calculator
        $calculatorCall = $calculatorRequest->calculate(pm()->input('first_operand'),
            pm()->input('second_operand'), pm()->select('operation'));

        // Afficher page
        return view('demo/index', [
            'jaxonCss' => $jaxon->css(),
            'jaxonScript' => $jaxon->script(true),
            // Appel Ajax vers une méthode de la classe Calculator
            'calculatorCall' => $calculatorCall,
        ]);
    }
}
```

L'appel à `$jaxon->request()` retourne une [requête Jaxon](/docs/v3x/requests/factory.html) vers la classe `Calculator`, qui est ensuite utilisé pour générer l'appel Ajax vers la méthode PHP `calculate()`.
Le contenu des éléments de la page est passé en paramètre à l'appel Ajax à l'aide de la fonction `pm()`.

Les méthodes `css()` et `script()` du plugin Jaxon pour Laravel retournent les [codes CSS et javascript](/docs/v3x/registrations/javascript.html) à inclure dans la page web.

Le code HTML ci-dessous est le contenu de la page, à ajouter dans le template `demo/index.blade.php`.

```html
<div class="row">
    <div class="col-md-2">
        <input class="form-control" id="first_operand" type="text" />
    </div>
    <div class="col-md-2">
        <select class="form-control" id="operation">
            <option value="a">+</option>
            <option value="s">-</option>
            <option value="m">*</option>
            <option value="d">/</option>
        </select>
    </div>
    <div class="col-md-2">
        <input class="form-control" id="second_operand" type="text" />
    </div>
    <div class="col-md-1">
        <button type="button" class="btn btn-primary btn-sm" onclick="{!! $calculatorCall !!}; return false;" > = </button>
    </div>
    <div class="col-md-2" id="result">
        ???
    </div>
</div>
```

Pour terminer, le code CSS et javascript de Jaxon doit être inséré dans le template `demo/index.blade.php` avec les variables `{!! $jaxonCss !!}` et `{!! jaxonScript !!}`.

Et voilà comment Jaxon permet d'appeler une classe PHP depuis une page web, et de mettre à jour la page depuis la classe PHP.
