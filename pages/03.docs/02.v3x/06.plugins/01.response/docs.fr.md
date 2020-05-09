---
title: Les plugins de réponse
menu: Les plugins de réponse
template: jaxon
---

Un plugin de réponse de Jaxon sert à enrichir la classe `Jaxon\Response\Response`.
Il ajoute de nouvelles fonctionalités dans une page web, par exemple afficher des fenêtres, ou des graphes.

#### Installation

Pour installer un plugin de réponse Jaxon, il suffit d'installer le package correspondant avec `Composer`.
Une fois installé, le plugin est automatiquement enregistré auprès de la librairie Jaxon, et son code CSS et javascript est automatiquement ajouté à celui de la librairie.

#### Configuration

Les plugins de réponse sont configurés de la même façon que la librairie Jaxon, à la différence que les noms des paramètres sont préfixés du nom du plugin.

La documentation de chaque plugin fournit la liste de ses paramètres de configuration.

#### Utilisation

Un plugin de réponse de Jaxon possède un nom, qui doit être unique dans toute l'application.
Ce nom permet d'accéder à une instance du plugin à partir d'un objet de la classe `Jaxon\Response\Response`.

L'exemple ci-dessous affiche une notification dans une page à l'aide du plugin [Dialogs](https://github.com/jaxon-php/jaxon-dialogs).
L'expression `$response->dialog` donne accès au plugin.

```php
class MyClass
{
    public function myMethod()
    {
        $response->dialog->success("You are now using the Toastr Notification plugin!!");
    }
```

#### Créer un plugin

Un plugin de réponse doit hériter de la classe abstraite `\Jaxon\Plugin\Response`, et définir la méthode abstraite `getName()`, qui renvoie son identifiant.
Les méthodes `getCss()`, `getJs()`, `getScript()` et `getReadyScript()`, qui ont des implémentations par défaut, permettent de personnaliser les codes CSS et javascript du plugin, qui seront ajoutés au code généré par la librairie.

Le plugin doit enfin définir ses propres fonctions. Pour exécuter des actions dans une page web, la méthode `response()` renvoie l'objet `Response` qui a appelé le plugin, et la méthode `addCommand()` ajoute un appel à une commande Jaxon dans cette même réponse.

Une fois le plugin créé, il faut le déclarer dans la librairie avec la fonction `jaxon_register_plugin()`, qui prend comme unique paramètre une instance du plugin.
