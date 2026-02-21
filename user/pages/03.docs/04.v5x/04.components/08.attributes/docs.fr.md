---
title: Les attributs et les annotations
menu: Attributs et annotations
template: jaxon
---

Les attributs et les annotations sont optionnels, et fournis dans les packages [`jaxon-php\jaxon-attributes`](https://github.com/jaxon-php\jaxon-attributes) et [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations).
Ils sont cependant recommandés, car ils simplifient l'usage d'autres fonctions, en permettant de définir leurs paramètres de configuration dans les fichiers des classes Jaxon, plutôt que dans le fichier de configuration.

Dans les classes enregistrées dans le fichier de configuration de Jaxon, on ne peut utiliser que l'une de ces deux fonctions.
Il faut donc choisir entre attributs et annotations.
Cependant, dans un package, il est possible de faire un choix différent. Mais de même, une seule de ces deux fonctions devra être utilisée dans toutes les classes du package.
Au final, pour utiliser simultanément les attributs et les annotations dans une même application, il faut déplacer les classes qui utilisent une fonction différente dans un package.

### Configuration

Pour utiliser les attributs ou les annotations dans une application, il faut donner à l'option de configuration `app.metadata.format` l'une des valeurs `attributes` ou `annotations`.
Dans un package, c'est à l'option `metadata.format` qu'il faut donner la valeur.

```php
    'app' => [
        'metadata' => [
            'format' => 'attributes',
        ],
        'packages' => [
            My\Sample\Package::class => [
                'metadata' => [
                    'format' => 'annotations',
                ],
            ],
        ],
    ],
```

### Cacher les métadonnées

Il est possible de définir un répertoire de cache, dans lequel les données issues du traitement des attributs et des annotations vont être sauvegardées, pour éviter de les traiter à chaque requête à l'application.

```php
    'app' => [
        'metadata' => [
            'format' => 'attributes',
            'cache' => [
                'enabled' => true,
                'dir' => '/path/to/the/metadata/cache',
            ]
        ],
        'packages' => [
            My\Sample\Package::class => [
                'metadata' => [
                    'format' => 'annotations',
                ],
            ],
        ],
    ],
```

### Les attributs et les annotations disponibles

> Note: lorsqu'un attribut ou une annotation est défini sur une méthode, ce doit être une méthode publique, qui sauf pour l'attribut `Jaxon\Attributes\Attribute\Export` et l'annotation `@export`, est exportée vers Javascript.

#### L'injection de dépendances

L'attribut `Jaxon\Attributes\Attribute\Inject` et l'annotation `@di` servent à configurer [l'injection de dépendances](../../features/dependency-injection.html).
Ils peuvent être définis sur des classes, des méthodes, ou des propriétés publiques ou protégées.

#### Les data bags

L'attribut `Jaxon\Attributes\Attribute\Databag` et l'annotation `@databag` servent à configurer les [data bags](../databags.html)
Ils peuvent être définis sur des classes ou des méthodes.

#### Le transfert de fichiers

L'attribut `Jaxon\Attributes\Attribute\Upload` et l'annotation `@upload` servent à configurer les [transferts de fichiers](../../features/upload.html)
Ils peuvent être définis uniquement sur des méthodes.

#### Les hooks

Les attributs `Jaxon\Attributes\Attribute\Before` et `Jaxon\Attributes\Attribute\After`, ainsi que les annotations `@before` et `@after`, servent à configurer les [hooks](../../features/hooks.html) à exécuter avant ou après la méthode appelée dans une requête.
Ils peuvent être définis sur des classes ou des méthodes.

#### Exclure des classes ou des méthodes

L'attribut `Jaxon\Attributes\Attribute\Exclude` et l'annotation `@exclude` servent à exclure des classes ou des méthodes publiques du [code Javascript généré](../../registrations/options.html).

#### Choisir les méthodes à exporter

L'attribut `Jaxon\Attributes\Attribute\Export` et l'annotation `@export` servent à définir plus finement les méthodes publiques à exporter dans le [code Javascript généré](../../registrations/options.html).
Ils peuvent être définis uniquement sur des classes.
