---
title: Les paramètres des appels Jaxon
menu: Paramètres
template: jaxon
---

Les appels aux composants Jaxon, bien qu'ils passent du navigateur au serveur, ont une sémantique d'appel de fonction et non d'appel à une API REST.
Les paramètres passés aux appels en Javascript doivent donc respecter l'ordre et les types présents dans la définition de la fonction en PHP.

Dans [l'exemple de la calculatrice](/examples/components/calculator.html), la fonction `calculate()` est appelée depuis un template.
Les paramètres sont lus dans la page, ont donc par défaut le type `string`.

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

### Conversion des paramètres

A partir de la version `5.8.0`, la librairie Jaxon permet de convertir automatiquement les paramètres reçus dans les appels depuis le navigateur.
Pour cela, il faut passer à la fonction un paramètre d'un type qui hérite de la classe `Jaxon\App\RequestParam`.

La classe `Jaxon\App\RequestParam` définit une fonction virtuelle `abstract public function set(mixed $value): void` qui va être appelée avec la valeur originelle du paramètre.
La classe peut alors valider cette valeur, la transformer, et définir une fonction qui retourne sa valeur finale.

Pour l'exemple de la calculatrice, la classe ci-dessous peut être définie pour les opérandes.
Elle va automatiquement valider les paramètres, et ensuite les convertir du type `string` vers le type `int`.

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
