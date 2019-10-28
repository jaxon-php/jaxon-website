---
title: The classes
menu: The classes
template: jaxon
---

The classes of an Armada application must inherit from the `Jaxon\Sentry\Armada` class, which provides them with functions to access other classes, and to manage requests, responses, views and sessions.

The `instance()` method (or its short version `cl()`) returns an instance of another Jaxon class in the same namespace. It takes the name of the class as a parameter, without the namespace.

For example, the instance of the `\Namespace\Subdir\Class` class in namespace `Namespace` will be returned by the following call.

```php
$myClass = $this->instance(':Subdir.Class');
```

If both classes are in the same subdirectory, this can be omitted, and the class name is prepended with a period.

```php
$myClass = $this->instance('.Class');
```

#### The `Response` object

All instances of the classes registered in a Armada application have access to the same `Response` object, through their `response` attribute.
This object is automatically initialized by the library, and allows to build the response to a request by calling several methods in one or more classes.

```php
class ClassA extends \Jaxon\Sentry\Armada
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
        // Call the doB() method of class ClassB
        $this->instance('.ClassB')->doB();
        return $this->response;
    }
}
```

```php
class ClassB extends \Jaxon\Sentry\Armada
{
    public function doB()
    {
        $this->response->alert('ClassB::doB() called.');
        return $this->response;
    }
}
```

#### The Request Factory

The `request()` method (or its short version `rq()`) returns a request to its calling class.
It provides a fluid interface that transforms any received call into a request to the method with the same name in the caller class.

```php
class ClassA extends \Jaxon\Sentry\Armada
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to a call to the doB() method in this class
        $this->response->onClick('btn-a', $this->rq()->doB());

        // Bind the click on the button with id "btn-b" to a call to the doB() method in class ClassB
        $this->response->onClick('btn-b', $this->ct('.ClassB')->rq()->doB());
        return $this->response;
    }
}
```

The contents of the webpage can be passed as parameters to calls using the [Request Factory](/docs/requests/factory) or the [PHP jQuery API](/docs/advanced/jquery), and their global functions `rq()` and `jq()`.

```php
class ClassA extends \Jaxon\Sentry\Armada
{
    public function doA()
    {
        // Parameter using the Request Factory
        $this->response->onClick('btn-a', $this->rq()->doB(rq()->form('form-user')));

        // Parameter using the PHP jQuery API
        $this->response->onClick('btn-b', $this->ct('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

#### The jQuery PHP API

The `jQuery()` method (or its short version `jq()`) adds a call to jQuery into the response.

```php
class ClassA extends \Jaxon\Sentry\Armada
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to a call to the doB() method in this class
        $this->jQuery('#btn-a')->click($this->rq()->doB(rq()->form('form-user')));

        // Bind the click on the button with id "btn-b" to a call to the doB() method in class ClassB
        $this->jQuery('#btn-b')->click($this->ct('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

The `$this->jQuery()` call is the same as `$this->response->jQuery()`.

#### The pagination

The `paginate()` method (or its short version `pg()`) creates pagination links with calls to a method of a Jaxon class.

```php
class ClassA extends \Jaxon\Sentry\Armada
{
    public function doA($pageNumber)
    {
        // Insert the pagination links into the page
        $pagination = $this->rq()->doA(rq()->page())->paginate($currentPage, $itemsPerPage, $totalPages);
        $this->response->assign('pagination-links', 'innerHTML', $pagination);
        return $this->response;
    }
}
```
