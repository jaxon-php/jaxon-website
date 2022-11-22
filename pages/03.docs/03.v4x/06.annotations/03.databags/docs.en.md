---
title: Data bags
menu: AData bags
template: jaxon
---

The `@databag` annotation defines data bags, which are data sets that are stored on client side, and made available at demand in Jaxon classes.

It can be declared on a class (it then applies on all its methods), or on the methods.
It can be repeated.

It takes a single parameter, the `data bag` identifier, which must be unique within the application.

```php
// The first_bag data bag can be accessed from all the methods of this class.
/**
 * @databag first_bag
 */
class HelloWorld extends \Jaxon\App\CallableClass
{
    // The second_bag data bag can be accessed only from this method.
    /**
     * @databag second_bag
     */
    public function doThat()
    {
        // Read data from or write data in data bags.
        $this->bag('first_bag')->set('first_value', $firstValue);
        $secondValue = $this->bag('second_bag')->get('second_value');

        return $this->response;
    }
}
```
