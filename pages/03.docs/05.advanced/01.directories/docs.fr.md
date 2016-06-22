---
title: Export de répertoires et namespaces
menu: Export de répertoires et namespaces
template: docs
---

Une application PHP moyenne peut contenir des dizaines, voire des centaines de classes. Exporter individuellement chaque classe avec Jaxon peut être fastidieux et générer des erreurs, en plus de produire un code verbeux.
Lorsqu'en plus les classes sont dans des namespaces, il est possible que plusieurs d'entre elles aient le même nom. Pour les distinguer dans le code javascript, le namespace devrait être pris en compte dans le nom de la classe javascript correspondante.

Les classes d'une application PHP vont généralement être installées dans un répertoire central, et réparties dans plusieurs de ses sous-répertoires. Ce répertoire peut éventuellement être associé à un namespace. Pour les gérer plus facilement, la librairie Jaxon permet d'enregistrer simplement toutes les classes présentes dans un répertoire, et son namespace s'il en existe un.

La fonction suivante ajoute un répertoire à la liste de ceux à enregister, ainsi que son namespace. Elle doit être appelée autant de fois qu'il y a de répertoires à prendre en compte.
```php
$jaxon->addClassDir($sPath, $sNamespace = null, array $aExcluded = array());
```

La fonction suivante exporte toutes les classes présentes dans les répertoires enregistrés avec la précédente.
```php
$jaxon->registerClasses();
```

Pour déterminer le nom de la classe javascript à créer, Jaxon introduit la notion de `classpath`. Pour une classe installée dans un sous-répertoire donné, le `classpath` est le chemin depuis le répertoire central jusqu'à celui qui contient la classe. S'il y a un `namespace` associé, il est préfixé au `classpath`. Enfin, les `/` et les `\` sont remplacés par des `.`, et le classpath est préfixé au nom de la classe PHP pour donner le nom de la classe javascript.

Si on enregistre un répertoire `X` sans namespace, la classe `C` installée dans le répertoire `X/Y/Z` aura comme classpath `Y.Z`, et le nom de la classe javascript est `Y.Z.C`. Si le namespace `N` est associé au répertoire `X`, il est préfixé au classpath, et le nom de la classe javascript est `N.Y.Z.C`.

Voici des exemples d'export de répertoires, [sans namespace](http://www.jaxon-php.org/classdirs.php), et [avec namespace](http://www.jaxon-php.org/namespaces.php).
