---
title: 'Create complex UI with an object-oriented library in PHP'
date: '2026-10-13 07:30'
media:
    images:
        - markus-spiske-unsplash.jpg
taxonomy:
    tag:
        - html-builder
        - ui-components
        - web-application
        - php
---

Despite the rise of JavaScript frameworks like React and Angular, building the UI on the backend is still a common feature in many web applications.
This is generally done with a template library, like [Twig](https://twig.symfony.com), [Blade](https://laravel.com/framework/docs/blade) or [Latte](https://latte.nette.org), and often using a different language which is close or related to the main application language.
A template engine then converts the template code into the application language, and generally caches the generated code for further reuse.

In the PHP ecosystem, there are many attempts to build application UIs using a class library.

Some of the most popular complements a template library.
[spatie/html](https://spatie.be/docs/laravel-html) extends [Laravel Blade](https://laravel.com/framework/docs/blade) with functions to build HTML elements.
[Symfony Forms](https://symfony.com/doc/current/forms.html) and [Nette Forms](https://doc.nette.org/fr/forms) can build forms, then validate and process their values.

Less known and less used, there are other PHP packages whose purpose is to build an application UI using a class library.
[ATK UI](https://www.atk4.org), [Viewi](https://viewi.net), [ui-awesome/html](https://github.com/ui-awesome/html), [danielescherzer/html-builder](https://github.com/DanielEScherzer/html-builder) and [Sirius HTML](https://github.com/siriusphp/html) are a few examples of such libraries. 

However, they don't match the advanced features of template libraries like `Blade` or `Twig`.
Even when providing a fluent API, generally those libraries can only create chunks of HTML or individual HTML components, without being able to tie them together into a complete UI block.
The user then needs to complement them with a template engine or plain PHP calls for string concatenation, iterative or conditional rendering.

### The HTML Builder library

[HTML Builder](https://github.com/lagdo/html-builder) is a PHP library that provides classes to represent the HTML components, as well as an API to build UIs using those classes.
A UI is built using a call tree, where each component receives its children as parameters.
HTML tags are created by calling methods named after the tags, while attributes are set using methods named `set` followed by the attribute name in PascalCase.

```php
    $this->html->div(
        $this->html->div(
            $this->html->label($this->html->text('Collation'))
                ->setFor('collation')
        )->setStyle('width: 30%;'),
        $this->html->div(
            $this->html->select(
                $this->html->option('(collation)')
                    ->setValue('')
                    ->setSelected(true),
                $this->html->each($collations, fn(array $groupCollations, $group) =>
                    $this->html->list(
                        $this->html->when($group === '', fn() =>
                            $this->html->each($groupCollations, $this->html->option(...))
                        ),
                        $this->html->when($group !== '', fn() =>
                            $this->html->optgroup(
                                $this->html->each($groupCollations, $this->html->option(...))
                            )->setLabel($group)
                        )
                    )
                )
            )->setName('collation')
        )->setStyle('width: 70%;')
    )->setStyle('display: flex; justify-content: space-between;')
```

This is the same template, built with `Twig`.

```twig
<div style="display: flex; justify-content: space-between;">
    <div style="width: 30%;">
        <label for="collation">Collation</label>
    </div>
    <div style="width: 70%;">
        <select name="collation">
            <option value="" selected>(collation)</option>
            {% for group, groupCollations in groups %}
                {% if group == '' %}
                    {% for collation in groupCollations %}
                        <option>{{ collation }}</option>
                    {% endfor %}
                {% else %}
                    <optgroup label="{{ group }}">
                        {% for collation in groupCollations %}
                            <option>{{ collation }}</option>
                        {% endfor %}
                    </optgroup>
                {% endif %}
            {% endfor %}
        </select>
    </div>
</div>
```

### The virtual components

What actually makes the `HTML Builder` library as powerful as a template library, is its virtual components.

A virtual component takes application data as input, and generates zero, one or more components as output.
It generates no additional HTML tag, so its output is only composed of those of the generated components.

There is a bidirectional relation between virtual and real components.
A real component can contain either real or virtual components as children, and a virtual component can generate a collection of real and virtual components.

Virtual components enable the `HTML Builder` library to generate HTML elements dynamically, a feature not available in the libraries mentioned above.

### The types of virtual components

The `HTML Builder` library provides 5 types of virtual components.

>Note: a closure passed to a virtual component must return a single component, which can be real or virtual.

#### The `When` component

The `When` component mimics the `if` clause of template languages.
It takes a boolean condition and a closure as parameters, and calls the closure only when the condition is true.

```php
    $this->html->when($user->isLoggedIn,
        fn() => $this->html->div($this->html->text($user->email)));
```

#### The `List` component

The `List` component groups a set of components into a single one.
It then allows to pass a list of components in places where a single component is expected, for example as the return value of a function.

```php
    $this->html->when($user->isLoggedIn,
        fn() => $this->html->list(
            $this->html->b($this->html->text('Welcome ')),
            $this->html->div($this->html->text($user->email))
        );
```

#### The `Pick` component

The `Pick` component mimics the PHP `switch` clause.
It takes multiple `When` components as input, and calls the closure provided by the first true condition.

```php
    $this->html->pick(
        $this->html->when($user === null,
            fn() => $this->html->html('Welcome')),
        $this->html->when($user->isAdmin,
            fn() => $this->html->html("Welcome&nbsp;<b>{$user->name}</b>")),
        $this->html->when(true,
            fn() => $this->html->html("Welcome&nbsp;{$user->name}"))
    );
```

#### The `Each` component

The `Each` component takes an array of items and a closure as parameters, and calls the closure with each item in the array.
It then generates the same number of components, each of which can be either real or virtual.

```php
    $this->html->select(
        $this->html->option('(Default)')->setValue(0),
        $this->html->each($choices,
            fn($choice) => $this->html->option($choice->label))
    );
```

The `Each` component can also take an iterator or a generator as parameter, and the closure also accepts the array key value as second parameter.

```php
    $this->html->select(
        $this->html->option('(Default)')->setValue(0),
        $this->html->each($choices,
            fn($choice, $id) => $this->html->option($choice->label)->setValue($id))
    );
```

#### The `Loop` component

The `Loop` component is the same as the `Each` component, but its second parameter is a `LoopItem` object, which provides various information about the current loop.

```php
    $this->html->select(
        $this->html->option('(Default)')->setValue(0),
        $this->html->loop($choices,
            fn($choice, $loop) => $this->list(
                $this->when($loop->current->group !== $loop->prev?->group,
                    fn() => $this->html->option($loop->current->group)
                        ->setClass('group-title disabled')),
                $this->html->option($choice->label)->setValue($id))
            )
    );
```

>Note: The `Loop` component was inspired by [this article on Twig](https://symfony.com/blog/new-in-symfony-8-1-a-new-for-loop-for-twig-4-0).

### Comparison with template engines

The `HTML Builder` library combines a fluent PHP API with a lightweight, object-oriented approach to HTML generation.

Its virtual components support dynamic content while deferring the execution of closures until rendering.
This keeps UI construction entirely within PHP, using a consistent fluent API from start to finish, without requiring a separate template compilation step.

The combination of regular and virtual components provides the building blocks needed to implement the main features commonly found in template engines, including conditional rendering and iteration, while preserving the fluent API.
Combined with PHP's object-oriented features, such as inheritance, traits, method overloading, and composition, this approach offers a flexible way to structure and reuse UI code.

Like template engines, `HTML Builder` can also be extended with custom functions to meet application-specific needs.

#### Why use HTML Builder?

When using the `HTML Builder` library, the application UI is organized as a library of PHP classes rather than a collection of template files.
This makes the UI independent of any particular application framework and eliminates the need for a separate template engine.

UI classes can accept structured objects and domain-specific data types instead of relying solely on simple arrays.
This allows the interfaces between the UI and other application components to be defined more explicitly, improving separation of concerns and making dependencies easier to understand.

A class-based UI can also benefit from familiar software engineering practices, including encapsulation, inheritance, code reuse, and unit testing.
For applications where the UI is maintained as part of the codebase, this approach can make the code easier to organize, maintain, and test.

#### What changes with HTML Builder?

Template engines commonly compile templates into PHP code and cache the compiled result for reuse.
This reduces the overhead of processing templates repeatedly and can provide a performance advantage over an object-based approach to HTML generation.

`HTML Builder` instantiates objects for HTML components and makes use of features such as magic methods, closures, and method calls to compose the final output.
These mechanisms introduce some runtime overhead compared with executing precompiled PHP code.

However, performance depends on the implementation, the structure of the UI, and the amount of work involved in rendering it.
The trade-off is an approach that emphasizes object-oriented composition, extensibility, and code reuse rather than minimizing runtime overhead.

Some template engines also provide a sandbox that allows untrusted templates to be executed with restricted capabilities, improving security.
Developers can define which functions templates are allowed to call.
This feature is particularly useful when an application needs to render templates provided by third parties.

`HTML Builder` does not provide a sandbox, as it is designed to build HTML directly from PHP code rather than to execute untrusted templates.
Its UI classes are intended to be part of the application's codebase, not to serve as a restricted execution environment for externally supplied templates.

### The UI Builder library

The [UI Builder](https://github.com/lagdo/ui-builder) library extends the `HTML Builder` library with functions for creating UI components based on CSS frameworks.
It provides a set of primitives for creating components such as buttons, cards, tabs, pagination, and more, as well as configuring their properties.

The `UI Builder` library is currently used to build the UI of the [Jaxon DbAdmin](https://github.com/lagdo/jaxon-dbadmin) application, and the example below is taken from its codebase.

```php
    $this->html->build(
        $this->html->buttonGroup(
            $this->html->button(
                $this->html->text($this->trans->lang('Columns ')),
                $this->html->when($columnCount > 0, fn() =>
                    $this->html->badge("$columnCount")->primary())
            )->outline()
                ->secondary()
                ->fullWidth(),
            $this->html->button(
                $this->html->text($this->trans->lang('Filters ')),
                $this->html->when($filterCount > 0, fn() =>
                    $this->html->badge("$filterCount")->primary())
            )->outline()
                ->secondary()
                ->fullWidth(),
            $this->html->button(
                $this->html->text($this->trans->lang('Order ')),
                $this->html->when($sorterCount > 0, fn() =>
                    $this->html->badge("$sorterCount")->primary())
            )->outline()
                ->secondary()
                ->fullWidth()
        )->fullWidth()
    );
```

The `UI Builder` library is separated into multiple PHP packages.

The [lagdo/ui-builder](https://github.com/lagdo/ui-builder) package provides the `BuilderInterface` interface, which defines the functions that each builder must implement.
It also provides base classes for UI components and implements a common set of functions shared by the different builders.

Each supported CSS framework has its own package, which implements the `Builder` class and the corresponding UI component classes.
Each component class defines how the component's HTML is generated for the target framework, using the functions provided by the [lagdo/ui-builder](https://github.com/lagdo/ui-builder) and [lagdo/html-builder](https://github.com/lagdo/html-builder) packages.

The framework-specific `Builder` class extends the `AbstractBuilder` class provided by the UI Builder package and only needs to specify the names of the component classes it uses.

The following CSS frameworks are currently supported:
- [Bootstrap 5](https://github.com/lagdo/ui-builder-bootstrap5)
- [Bootstrap 4](https://github.com/lagdo/ui-builder-bootstrap4)

The [Bootstrap 3](https://github.com/lagdo/ui-builder-bootstrap3) package is deprecated.

The packages for [Tailwind CSS](https://github.com/lagdo/ui-builder-tailwind) and [Bulma](https://github.com/lagdo/ui-builder-bulma) are under development and will be available soon.

### Closing thoughts

Generating an application UI entirely in PHP has always been challenging.
PHP libraries designed for this purpose have traditionally lacked many of the features offered by template engines, often requiring developers to supplement them with a template engine or direct PHP calls.

Thanks to its virtual components, the [HTML Builder](https://github.com/lagdo/html-builder) library bridges this gap.
Its fluent API and methods named after HTML tags make it easier to build complex application UIs entirely in PHP.

The [UI Builder](https://github.com/lagdo/ui-builder) library takes this approach a step further by extending the `HTML Builder` library with higher-level UI components, such as buttons, cards, tabs, and pagination.
Framework-specific packages generate the corresponding HTML for CSS frameworks such as `Bootstrap`, `Tailwind CSS`, and `Bulma`.
