---
title: Exporter des répertoires
menu: Répertoires
template: jaxon
---

Une application PHP moyenne peut contenir des dizaines, voire des centaines de classes. Exporter individuellement chaque classe avec Jaxon peut être fastidieux et générer des erreurs, en plus de produire un code verbeux.

Les classes d'une application PHP vont généralement être réparties dans quelques répertoires, chacun éventuellement être associé à un namespace.
La librairie Jaxon permet alors d'enregistrer en une fois toutes les classes présentes dans un répertoire.

Par exemple, prenons un répertoire `/the/class/dir` qui contient plusieurs classes parmi lesquelles, dans le fichier `/the/class/dir/My/App/MyClass.php`
```php
class MyClass
{
    public function myMethod()
    {
        // Function body
    }
}
```

Toutes les classes présentes dans le répertoire sont enregistrées avec Jaxon ainsi.
```php
$jaxon->addClassDir('/the/class/dir');
$jaxon->registerClasses();
```

Pour déterminer le nom de la classe javascript à créer, Jaxon introduit la notion de `classpath`.  
Pour une classe exportée dans un répertoire donné, le `classpath` est le chemin depuis ce répertoire jusqu'au sous-répertoire qui contient la classe, avec les `/` et les `\` remplacés par des `.`.  
Le `classpath` est préfixé au nom de la classe PHP pour donner le nom de la classe javascript.

Dans l'exemple ci-dessus, le nom de la classe javascript sera `My.App.MyClass`.
