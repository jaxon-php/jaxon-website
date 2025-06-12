---
title: Un exemple simple
menu: Un exemple simple
template: jaxon
---

Pour montrer comment fonctionne la librairie Jaxon, nous présentons ici un exemple simple: une calculatrice qui prend en paramètres une opération arithmétique et ses deux opérandes, effectue le calcul et affiche le résultat à l'écran.

Ce composant fait partie des [exemples de Jaxon](https://github.com/jaxon-php/jaxon-examples), et vous pouvez donc le voir fonctionner en installant ce package.

La mise en oeuvre de cette calculatrice nécessite deux [composants d'UI](../../components/node-components.html), l'un pour afficher l'écran de la calculatrice, l'autre pour afficher le résultat de l'opération, et un [composant fonctionnel](../../components/func-components.html), qui effectuera le calcul.

En voici une capture d'écran, avec les deux composants d'UI en évidence.

![Jaxon Calculator](/images/jaxon-calculator.png)

### Le composant principal

C'est un [composant d'UI](../../components/node-components.html), qui affiche l'écran de la calculatrice.
Il va servir de point d'entrée pour insérer la calculatrice dans une page web.


```php
namespace App\Calculator;

use Jaxon\App\NodeComponent;
use Stringable;

class Calc extends NodeComponent
{
    public function html(): Stringable
    {
        return $this->view()->render('calculator::wrapper');
    }
}
```

Dans le template `calculator::wrapper`, des handlers sont attachés aux boutons avec `attr()->click()`, et le composant `Result` est attaché au noeud du DOM qui doit afficher le résultat avec `attr()->bind()`.

```php
// Get the components
$rqCalc = rq(App\Calculator\Calc::class);
$rqCalcFunc = rq(App\Calculator\CalcFunc::class);
$rqResult = rq(App\Calculator\Result::class);
// Get the values in the HTML fields.
$operator = je('operator')->rd()->select();
$operandA = je('operand-a')->rd()->input();
$operandB = je('operand-b')->rd()->input();
?>
<form>
    <div class="row mb-3">
        <div class="col-md-4">
            <button type="button" class="btn btn-primary w-100"
                <?php echo attr()->click($rqCalc->render()) ?>>Clear</button>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" id="operand-a" />
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <select class="form-select" id="operator">
                <option value="addition">+</option>
                <option value="subtraction">-</option>
                <option value="multiplication">*</option>
                <option value="division">/</option>
            </select>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" id="operand-b" />
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <button type="button" class="btn btn-primary w-100"
                <?php echo attr()->click($rqCalcFunc->calculate($operator, $operandA, $operandB)) ?>>=</button>
        </div>
        <div class="col-md-8" <?php echo attr()->bind($rqResult) ?>>
        </div>
    </div>
</form>
```

### Le composant de résultat

Il récupère le résultat de l'opération, le formatte et l'affiche à l'endroit souhaité.
La fonction `stash()` permet de [partager des données](../../components/stashes.html) entre des composants.

```php
use Jaxon\App\NodeComponent;
use Stringable;

class Result extends NodeComponent
{
    public function html(): Stringable
    {
        return $this->view()->render('calculator::result', [
            'result' => $this->stash()->get('calculator.result'),
            'operator' => $this->stash()->get('calculator.operator'),
        ]);
    }
}
```

Le template `calculator::result` affiche le résultat dans une zone de texte en lecture seule.

```php
<input type="text" class="form-control" value="<?= $this->operator !== 'division' ?
    $this->result : sprintf("%.2f", $this->result) ?>" readonly="readonly" />
```

### Le composant fonctionnel

Le troisième composant est un [composant fonctionnel](../../components/func-components.html). Cela signifie qu'il n'affiche pas de code HTML, mais fournit des fonctions à appeler depuis une page web.

Dans cet exemple, il fournit la fonction de calcul, pour laquelle il utilise un service qui lui est injecté.
Il affiche également un message en cas d'erreur, à l'aide de la [fonction de dialogue](../../features/dialogs.html) fournie par le trait `DialogTrait`.

```php
namespace App\Calculator;

use Exception;
use Jaxon\App\Dialog\DialogTrait;
use Jaxon\App\FuncComponent;
use Service\Calculator\Calculator;

class CalcFunc extends FuncComponent
{
    use DialogTrait;

    /**
     * @param Calculator $calculator
     */
    public function __construct(private Calculator $calculator)
    {}

    /**
     * @param string $operator
     * @param string $operandA
     * @param string $operandB
     *
     * @return void
     */
    public function calculate(string $operator, string $operandA, string $operandB): void
    {
        $operator = trim($operator);
        $operandA = trim($operandA);
        $operandB = trim($operandB);
        try
        {
            $result = $this->calculator->calculate($operator, $operandA, $operandB);
            // Share the result value with the other components.
            $this->stash()->set('calculator.operator', $operator);
            $this->stash()->set('calculator.result', $result);
            // Render the result component.
            $this->cl(Result::class)->render();
        }
        catch(Exception $e)
        {
            $this->alert()->title('Error!!!')->error($e->getMessage());
        }
    }
}
```

La fonction du composant est liée à l'évènement `click` sur le bouton dans le template `calculator::wrapper` avec ce code.

```php
<button type="button" class="btn btn-primary w-100"
    <?php echo attr()->click($rqCalcFunc->calculate($operator, $operandA, $operandB)) ?>>=</button>
```

### Affichage du composant dans une page web

Maintenant que nos composants sont prêts, nous allons insérer la calculatrice dans une page web.

```php
use App\Calculator\Calc;
?>

<div class="row" <?php echo attr()->bind(rq(Calc::class)) ?>>
<?php echo cl(Calc::class)->html() ?>
</div>
```

La fonction `attr()->bind()` attache le composant à un noeud du DOM, et la fonction `cl(Calc::class)->html()` renvoie le code HTML initial du composant, qui est donc inclus dans la page.

### La configuration

Le [fichier de configuration](../../about/configuration.html) déclare les [classes Jaxon avec leur namespace](../../registrations/namespaces.html), un [répertoire de templates PHP](../../features/views.html) à afficher avec le `view renderer` de Jaxon, la [librairie `CuteAlert`](https://github.com/gustavosmanc/cute-alert) pour afficher [les alertes et notifications](../../features/dialogs.html), et un service dans le [conteneur de dépendences](../../features/dependency-injection.html).

```php
return [
    'app' => [
        'directories' => [
            [
                'path' => __DIR__ . '/../classes/calculator/app',
                'namespace' => 'App\\Calculator',
            ],
        ],
        'views' => [
            'calculator' => [
                'directory' => dirname(__DIR__) . '/templates/calculator',
                'extension' => '.php',
                'renderer' => 'jaxon',
            ],
        ],
        'dialogs' => [
            'default' => [
                'alert' => 'cute',
            ],
        ],
        'container' => [
            'auto' => [
                Service\Calculator\Calculator::class,
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'debug' => [
                'on' => false,
            ],
            'request' => [
                'uri' => "/exp/ajax.php?exp=calculator",
            ],
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'lib' => [
                'uri' => '/js',
            ],
        ],
    ],
];
```

Ce fichier doit être chargé au démarrage de l'application.

```php
// Load the config
jaxon()->app()->setup($configDir . '/calculator.php');
```
