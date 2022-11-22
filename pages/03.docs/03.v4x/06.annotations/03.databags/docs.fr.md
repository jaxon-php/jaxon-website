---
title: Les data bags
menu: Les data bags
template: jaxon
---

L'annotation `@databag` permet de définir des [data bags](../05.databags/), qui sont des données stockées sur le client et disponibles à la demande dans les classes Jaxon.

Elle peut être définie sur la classe (elle s'applique alors à toutes les méthodes), et sur les méthodes.
Elle peut être repétée.

Elle prend un seul paramètre, l'identifiant du `data bag`, qui doit être unique dans l'application.

```php
// Le data bag first_bag sera accessible dans toutes les méthodes de cette classe.
/**
 * @databag('name' => 'first_bag')
 */
class HelloWorld extends \Jaxon\App\CallableClass
{
    // Le data bag second_bag sera disponible uniquement dans cette méthode.
    /**
     * @databag second_bag
     */
    public function doThat()
    {
        // Lire ou écrire des données dans les data bags.
        $this->bag('first_bag')->set('first_value', $firstValue);
        $secondValue = $this->bag('second_bag')->get('second_value');

        return $this->response;
    }
}
```
