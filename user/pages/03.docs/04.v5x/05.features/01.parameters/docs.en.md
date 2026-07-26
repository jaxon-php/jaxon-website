---
title: The Jaxon call parameters
menu: Parameters
template: jaxon
---

Although calls to Jaxon components travel from the browser to the server, they follow function-call semantics rather than those of a REST API call.
Consequently, the parameters passed in JavaScript calls must adhere to the order and types specified in the PHP function definition.

In [the calculator example](/examples/components/calculator.html), the `calculate()` function is called from a template.
The parameters are read from the page, so they default to the `string` type.

```php
class CalcFunc extends FuncComponent
{
    /**
     * @param string $operator
     * @param string $operandA
     * @param string $operandB
     *
     * @return void
     */
    public function calculate(string $operator, string $operandA, string $operandB): void
    {
        //
    }
}
```

```php
        <div class="col-md-4">
            <button type="button" class="btn btn-primary w-100" <?= attr()
                ->click(rq(App\Calculator\CalcFunc::class)->calculate(
                    pm()->select('operator'),
                    pm()->input('operand-a'),
                    pm()->input('operand-b')
                )) ?>>Calculate</button>
        </div>
```

### Parameters conversion

Starting from version `5.8.0`, the Jaxon library allows for the automatic conversion of parameters received from browser-based calls.
To achieve this, the function must be passed a parameter that is of a type inheriting from the `Jaxon\App\RequestParam` class.

The `Jaxon\App\RequestParam` class defines an abstract method `abstract public function set(mixed $value): void` which is called with the parameter's original value.
The class can then validate the value, transform it, and define a function that returns the final value.

For the calculator example, the class below can be defined to handle the operands.
It will automatically validate the parameters and then convert them from the `string` type to the `int` type.

```php
use Exception;
use Jaxon\App\RequestParam;

class CalcOperand extends RequestParam
{
    /**
     * @var int
     */
    private int $value;

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function set(mixed $value): void
    {
        if(!is_string($value))
        {
            throw new Exception("Incorrect type for the operand.");
        }
        if(($value = trim($value)) === '')
        {
            throw new Exception("The operand must not be empty.");
        }
        if(!is_numeric($value))
        {
            throw new Exception("$value is not a valid operand.");
        }
        $this->value = intval($value);
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }
}
```

```php
class CalcFunc extends FuncComponent
{
    /**
     * @param string $operator
     * @param CalcOperand $operandA
     * @param CalcOperand $operandB
     *
     * @return void
     */
    public function calculate(string $operator, CalcOperand $operandA, CalcOperand $operandB): void
    {
        //
    }
}
```
