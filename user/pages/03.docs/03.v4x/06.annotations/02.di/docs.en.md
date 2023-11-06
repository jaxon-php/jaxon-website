---
title: Dependency injection
menu: Dependency injection
template: jaxon
---

The `@di` annotation defines [dependency injection](../../05.features/03.dependency-injection/) in Jaxon classes.

When applied to methods and classes, it takes the name and the class of the attribute as parameters.

```php
class JaxonExample
{
    /**
     * @var \App\Services\Translator
     */
     protected $translator;

    /**
     * @di('attr' => 'translator', class => '\App\Services\Translator')
     */
    public function translate(string $phrase)
    {
        // The $translator property is set from the DI container when this method is called.
        $phrase = $this->translator->translate($phrase);
    }
}
```

The class parameter is optional, and can be omitted if it is already specified by a `@var` annotation.

```php
class JaxonExample
{
    /**
     * @var \App\Services\Translator
     */
     protected $translator;

    /**
     * @di('attr' => 'translator')
     */
    public function translate(string $phrase)
    {
        // The $translator property is set from the DI container when this method is called.
        $phrase = $this->translator->translate($phrase);
    }
}
```

When applied to properties, it takes the class of the property as only parameter, which can be omitted if it is already specified by a `@var` annotation.

```php
class JaxonExample
{
    /**
     * @di(class => '\App\Services\Translator')
     */
     protected $translator;

    public function translate(string $phrase)
    {
        // The $translator property is set from the DI container when this method is called.
        $phrase = $this->translator->translate($phrase);
    }
}
```

```php
class JaxonExample
{
    /**
     * @di
     * @var \App\Services\Translator
     */
     protected $translator;

    public function translate(string $phrase)
    {
        // The $translator property is set from the DI container when this method is called.
        $phrase = $this->translator->translate($phrase);
    }
}
```

If the class name does not start with a `"\"`, then the corresponding fully qualified name (FQN) will be set using
either the `use` or the `namespace` statements in the source file.

```php
namespace App\Ajax;

use App\Services\Translator;

class JaxonExample
{
    /**
     * @var Translator
     */
     protected $translator;

    /**
     * @var Formatter
     */
     protected $formatter;

    /**
     * @di('attr' => 'translator', class => 'Translator')
     * @di('attr' => 'formatter', class => 'Formatter')
     */
    public function translate(string $phrase)
    {
        // The Translator FQN is defined by the use instruction => App\Services\Translator.
        // The Formatter FQN is defined by the current namespace => App\Ajax\Formatter.
        $phrase = $this->formatter->format($this->translator->translate($phrase));
    }
}
```

The PHP-DOC syntax can also be used.

```php
namespace App\Ajax;

use App\Services\Translator;

class JaxonExample
{
    /**
     * @var Translator
     */
     protected $translator;

    /**
     * @var Formatter
     */
     protected $formatter;

    /**
     * @di $translator   Translator
     * @di $formatter    Formatter
     */
    public function translate(string $phrase)
    {
        // The Translator FQN is defined by the use instruction => App\Services\Translator.
        // The Formatter FQN is defined by the current namespace => App\Ajax\Formatter.
        $phrase = $this->formatter->format($this->translator->translate($phrase));
    }
}
```

```php
namespace App\Ajax;

use App\Services\Translator;

/**
 * @di $translator   Translator
 * @di $formatter    Formatter
 */
class JaxonExample
{
    /**
     * @var Translator
     */
     protected $translator;

    /**
     * @var Formatter
     */
     protected $formatter;

    public function translate(string $phrase)
    {
        // The Translator FQN is defined by the use instruction => App\Services\Translator.
        // The Formatter FQN is defined by the current namespace => App\Ajax\Formatter.
        $phrase = $this->formatter->format($this->translator->translate($phrase));
    }
}
```

```php
namespace App\Ajax;

use App\Services\Translator;

class JaxonExample
{
    /**
     * @di  Translator
     * @var Translator
     */
     protected $translator;

    /**
     * @di  Formatter
     * @var Formatter
     */
     protected $formatter;

    public function translate(string $phrase)
    {
        // The Translator FQN is defined by the use instruction => App\Services\Translator.
        // The Formatter FQN is defined by the current namespace => App\Ajax\Formatter.
        $phrase = $this->formatter->format($this->translator->translate($phrase));
    }
}
```
