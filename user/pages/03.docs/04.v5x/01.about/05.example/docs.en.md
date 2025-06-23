---
title: A simple example
menu: A simple example
template: jaxon
---

To demonstrate how the Jaxon library works, we present here a simple example: a calculator that takes as parameters an arithmetic operation and its two operands, performs the calculation and displays the result on the screen.

This component is included in the [Jaxon examples](https://github.com/jaxon-php/jaxon-examples), so you can see it working after installing that package.

The implementation of the calculator requires two [UI components](../../components/node-components.html), one to display the calculator screen, the other to display the operation result, and a [functional component](../../components/func-components.html), which will perform the calculation.

Here's a screenshot, with the two UI components highlighted.

![Jaxon Calculator](/images/jaxon-calculator.png)

### The main component

It is a [UI component](../../components/node-components.html), which will display the calculator screen.
It will also serve as entry point to insert the calculator in a web page.


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

In the `calculator::wrapper` template, the handlers are attached to buttons with `attr()->click()`, and the `Result` component is attached to the DOM node that will display the result with `attr()->bind()`.

```php
<?php
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
                <?= attr()->click($rqCalc->render()) ?>>Clear</button>
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
                <?= attr()->click($rqCalcFunc->calculate($operator, $operandA, $operandB)) ?>>=</button>
        </div>
        <div class="col-md-8" <?= attr()->bind($rqResult) ?>>
        </div>
    </div>
</form>
```

### The result component

It retrieves the result of the operation, formats it and displays it in the desired location.
The `stash()` function allows to [share data](../../components/stash.html) between components.

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

The `calculator::result` template displays the result in a read-only text zone.

```php
<input type="text" class="form-control" value="<?= $this->operator !== 'division' ?
    $this->result : sprintf("%.2f", $this->result) ?>" readonly="readonly" />
```

### The functional component

The third component is a [functional component](../../components/func-components.html). This means that it doesn't display HTML code, but provides functions to be called from a web page.

In this example, it provides the calculation function, for which it uses a service injected into it.
It also displays a message in case of an error, using the [dialog function](../../ui-features/dialogs.html) provided by the `DialogTrait`.

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

The component function is bound to the `click` event on the button in the `calculator::wrapper` template with this code.

```php
<button type="button" class="btn btn-primary w-100" <?= attr()
    ->click($rqCalcFunc->calculate($operator, $operandA, $operandB)) ?>>=</button>
```

### Displaying the component in a web page

Now that our components are ready, we need to embed the calculator into a web page.

```php
<?php
use App\Calculator\Calc;
?>

<div class="row" <?= attr()->bind(rq(Calc::class)) ?>>
    <?= cl(Calc::class)->html() ?>
</div>
```

The `attr()->bind()` attaches the component to a DOM node, and the `cl(Calc::class)->html()` function returns the initial HTML code of the component, which is then included in the page.

### The configuration

The [configuration file](../../about/configuration.html) declares the [Jaxon classes with their namespace](../../registrations/namespaces.html), a [directory of PHP templates](../../ui-features/views.html) to be rendered with the Jaxon `view renderer`, the [`CuteAlert` library](https://github.com/gustavosmanc/cute-alert) to show [alerts and notifications](../../ui-features/dialogs.html), and a service in the [dependency container](../../features/dependency-injection.html).

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

That file needs to be loaded when starting the application.

```php
// Load the config
jaxon()->app()->setup($configDir . '/calculator.php');
```
