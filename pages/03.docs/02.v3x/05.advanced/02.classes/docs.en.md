---
title: The classes
menu: The classes
template: jaxon
---

The classes which are registered with Jaxon can inherit from the `Jaxon\CallableClass` class, which provides them with functions to manage requests, responses, views and sessions.

#### Retrieve an instance of another class

The `cl()` method returns an instance of another registered Jaxon class. It takes the full name (with namespace) of the class as a parameter.

For example, the instance of the `\Namespace\Subdir\Class` will be returned by the following call.

```php
$myClass = $this->cl('Namespace\Subdir\Class');
```

The character `.` can also be used as a separator/

```php
$myClass = $this->cl('Namespace.Subdir.Class');
```

If the class name starts with the character `:`, the class is found in the same namespace as the caller.

```php
$myClass = $this->cl(':Subdir.Class');
```

If the class name starts with the character `.`, the class is found in the same directory as the caller.

```php
$myClass = $this->cl('.Class');
```

#### The `Response` object

All instances of the classes that have inherited from `Jaxon\CallableClass` have access to the same `Response` object, through their `response` attribute.
This attribute is automatically initialized by the library, and allows to build the response to a request by calling several methods in one or more classes.

```php
class ClassA extends \Jaxon\CallableClass
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
        $this->cl('.ClassB')->doB();
        return $this->response;
    }
}
```

```php
class ClassB extends \Jaxon\CallableClass
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
class ClassA extends \Jaxon\CallableClass
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to a call to the doB() method in this class
        $this->response->onClick('btn-a', $this->rq()->doB());

        // Bind the click on the button with id "btn-b" to a call to the doB() method in class ClassB
        $this->response->onClick('btn-b', $this->cl('.ClassB')->rq()->doB());
        return $this->response;
    }
}
```

The contents of the webpage can be passed as parameters to calls using the [Request Factory](../../requests/factory) or the [PHP jQuery API](../../advanced/jquery), and their global functions `pr()` and `jq()`.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA()
    {
        // Parameter using the Request Factory
        $this->response->onClick('btn-a', $this->rq()->doB(pr()->form('form-user')));

        // Parameter using the PHP jQuery API
        $this->response->onClick('btn-b', $this->cl('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

#### The jQuery PHP API

The `jq()` adds a call to jQuery into the response.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to a call to the doB() method in this class
        $this->jq('#btn-a')->click($this->rq()->doB(rq()->form('form-user')));

        // Bind the click on the button with id "btn-b" to a call to the doB() method in class ClassB
        $this->jq('#btn-b')->click($this->cl('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

The `$this->jq()` call is the same as `$this->response->jQuery()`.

#### The pagination

The `paginate()` method (or its short version `pg()`) creates pagination links with calls to a method of a Jaxon class.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA($pageNumber)
    {
        // Insert the pagination links into the page
        $pagination = $this->rq()->doA(pr()->page())->paginate($currentPage, $itemsPerPage, $totalPages);
        $this->response->assign('pagination-links', 'innerHTML', $pagination);
        return $this->response;
    }
}
```
