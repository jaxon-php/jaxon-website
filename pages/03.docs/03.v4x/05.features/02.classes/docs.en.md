---
title: The Jaxon\App\CallableClass class
menu: The Jaxon\App\CallableClass class
template: jaxon
---

The classes which are registered with Jaxon can inherit from the `Jaxon\App\CallableClass` class, which provides them with helper functions to manage requests, responses, views and sessions.

#### Retrieve an instance of another class

The `cl()` method returns an instance of another registered Jaxon class. It takes the full name (with namespace) of the class as a parameter.

For example, the instance of the `\Namespace\Subdir\Class` will be returned by the following call.

```php
$myClass = $this->cl('Namespace\Subdir\Class');
```

The character `.` can also be used as a separator.

```php
$myClass = $this->cl('Namespace.Subdir.Class');
```

#### The `Response` object

All instances of the classes that have inherited from `Jaxon\App\CallableClass` have access to the same `Response` object, through their `response` attribute.
This attribute is automatically initialized by the library, and allows to build the response to a request by calling several methods in one or more Jaxon classes.

```php
class ClassA extends \Jaxon\App\CallableClass
{
    public function doA()
    {
        $this->response->alert('ClassA::doAB() called.');
        // Call the doB() method of this class
        $this->doB();
        return $this->response;
    }

    public function doB()
    {
        $this->response->alert('ClassA::doB() called.');
        // Call the doA() method
        $this->doA();
        // Call the doB() method of class ClassB
        $this->cl(ClassB::class)->doB();
        return $this->response;
    }
}
```

```php
class ClassB extends \Jaxon\App\CallableClass
{
    public function doB()
    {
        $this->response->alert('ClassB::doB() called.');
        return $this->response;
    }
}
```

#### The Request Factory

The `rq()` method returns a request to its calling class.
It provides a fluid interface that transforms a call to any of its method into a request to the same method, which can then be bound to an event on an element in the web page.

```php
class ClassA extends \Jaxon\App\CallableClass
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to an ajax call to the doB() method in this class
        $this->response->onClick('btn-a', $this->rq()->doB());

        // Bind the click on the button with id "btn-b" to an ajax call to the doB() method in class ClassB
        $this->response->onClick('btn-b', $this->cl(ClassB::class)->rq()->doB());
        return $this->response;
    }
}
```

The contents of the webpage can be passed as parameters to calls using the [Request Factory](../../requests/factory) or the [PHP jQuery API](../../responses/jquery), and their global functions `Jaxon\pm()` and `Jaxon\jq()`.

```php
class ClassA extends \Jaxon\App\CallableClass
{
    public function doA()
    {
        // Parameter using the Request Factory
        $this->response->onClick('btn-a', $this->rq()->doB(pm()->form('form-user')));

        // Parameter using the PHP jQuery API
        $this->response->onClick('btn-b', $this->cl(ClassB::class)->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

#### The jQuery PHP API

The `\jq()` adds a call to jQuery into the response.

```php
use function Jaxon\rq;

class ClassA extends \Jaxon\App\CallableClass
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to an ajax call to the doB() method in this class
        $this->jq('#btn-a')->click($this->rq()->doB(rq()->form('form-user')));

        // Bind the click on the button with id "btn-b" to an ajax call to the doB() method in class ClassB
        $this->jq('#btn-b')->click($this->cl(ClassB::class)->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

#### The pagination

The `paginate()` method (or its short version `pg()`) creates pagination links with calls to a method of a Jaxon class.

```php
class ClassA extends \Jaxon\App\CallableClass
{
    public function doA($pageNumber)
    {
        // Insert the pagination links into the page
        $pagination = $this->rq()->doA(pm()->page())->paginate($currentPage, $itemsPerPage, $totalPages);
        $this->response->assign('pagination-links', 'innerHTML', $pagination);
        return $this->response;
    }
}
```
