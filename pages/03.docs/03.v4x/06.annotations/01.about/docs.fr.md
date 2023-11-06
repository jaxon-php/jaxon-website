---
title: Les annotations
menu: Les annotations
template: jaxon
---

Les annotations sont optionnelles, et fournies dans le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations).

Elles sont cependant recommandées, car elles simplifient l'usage d'autres fonctions, en permettant de définir leurs paramètres de configuration dans les fichiers des classes Jaxon, plutôt que dans le fichier de configuration.

Pour les utiliser, il faut installer le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations), et donner à l'option `core.annotations.enabled` la valeur booléenne `true`.

#### Syntaxe des annotations

Les annotations des classes Jaxon utilisent la syntaxe `docblock`, et peuvent être ajoutées à la classe, à ses propriétés ou à ses méthodes.

```php
/**
 * @databag bag_name
 */
class HelloWorld
{
    /**
     * @di
     * @var \App\Services\Translator
     */
    protected $translator;

    /**
     * @upload field_id
     */
    public function doThat()
    {
    }
}
```

Les paramètres d'une annotation acceptent deux types de syntaxe.

Avec la syntaxe `PHP-DOC`, les paramètres suivent le nom de l'annotation.

```php
class HelloWorld
{
    /**
     * @databag bag_name
     */
    public function doThat()
    {
    }
}
```

Les paramètres peuvent également être mis entre parenthèses, avec une syntaxe similaire aux tableaux en PHP.
Dans ce cas, ils peuvent être nommés.

```php
class HelloWorld
{
    /**
     * @databag('name' => 'bag_name')
     */
    public function doThat()
    {
    }
}
```

#### Annotations disponibles

Dans sa version 2.1, 6 instructions d'annotations sont fournis.

- `@di`, pour [l'injection de dépendance](../../05.features/03.dependency-injection/)
- `@databag`, pour les [data bags](../../05.features/04.databags/)
- `@upload`, pour les [transfert de fichiers](../../05.features/06.upload/)
- `@before`, pour des [hooks](../../05.features/05.hooks/) à exécuter avant la méthode appelée
- `@after`, pour des [hooks](../../05.features/05.hooks/) à exécuter après la méthode appelée
- `@exclude`, pour ne pas exporter des méthodes publiques
