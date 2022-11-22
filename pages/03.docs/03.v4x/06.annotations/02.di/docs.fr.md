---
title: L'injection de dépendance
menu: L'injection de dépendance
template: jaxon
---

L'annotation `@di` définit des objets à injecter dans les classes Jaxon.

Elle peut être définie sur la classe, sur les attributs publics et protégés, et sur les méthodes.
Elle peut être repétée.

Sur une classe ou sur une méthode, cette annotation prend en paramètre le nom de l'attribut, et son type.
Rappelons que ce type doit être déclaré avec [l'injection de dépendance](../04.dependency-injection/).
```php
/**
 * @di('attr' => 'translator', class => '\App\Services\Translator') 
 * @di $translator \App\Services\Translator
 */
```

Si l'attribut est déjà déclaré avec un type, celui-ci peut être omis dans l'annotation.
```php
/**
 * @var \App\Services\Translator
 */
protected $translator;

/**
 * @di('attr' => 'translator') 
 * @di $translator
 */
```

Sur un attribut, le nom de l'annotation doit être omis.
```php
use App\Services\Translator;

/**
 * @di Translator
 */
protected $translator;
```

Si le type de l'attribut est déjà déclaré, il peut aussi être omis.
```php
use App\Services\Translator;

/**
 * @di
 * @var Translator
 */
protected $translator;
```
