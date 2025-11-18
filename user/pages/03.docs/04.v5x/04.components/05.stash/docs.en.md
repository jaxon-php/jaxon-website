---
title: Data stash
menu: Data stash
template: jaxon
---

The `data stash` is an object that is used to store data during the request processing, and whose lifetime is therefore limited to the processing of the request.

The data stored in the `data stash` will be accessible to all the components instantiated while processing the request.
It therefore allows data to be shared between different components.

#### Usage

All Jaxon component classes have a `stash()` function that returns the same `data stash` object.
This object has two functions, `set()` and `get()`, that allow the developer to set or read a value from the `stash`, respectively.

```php
class FirstClass extends \Jaxon\App\FuncComponent
{
    public function save()
    {
        $this->stash()->set('value_key', $value);
    }

    public function read()
    {
        $value = $this->stash()->get('value_key');
    }
}
```

The second parameter of the `set()` function can be either the value to be stored or a callback that returns that value.
If passed a callback, it will be called the first time the value is read.

Combined with `data bags`, the `data stash` implements the equivalent of an application state, but whose content will depend on the component called by the Jaxon request.

```php
/**
 * @databag bag_key
 * @before init
 */
class FirstClass extends \Jaxon\App\FuncComponent
{
    protected function init()
    {
        // Save the object in the stash
        $this->stash()->set('object_id', function() {
            $id = $this->bag('bag_key')->get('object_id');
            // Find and return the object
            // ...
        });
    }

    public function read()
    {
        // Get the object from the stash
        $object = $this->stash()->get('object_id');

        // Call a method in another class
        $this->cl(SecondClass::class)->doThat();
    }
}
```

```php
class SecondClass extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        // Get the object from the stash
        $object = $this->stash()->get('object_id');
        // ...
    }
}
```

The `@before` annotation defines a method to be called before the one targeted by the ajax request.
