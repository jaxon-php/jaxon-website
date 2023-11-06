---
title: Enrichir l'objet Response avec des plugins
menu: Plugins
template: jaxon
---

Un plugin de réponse de Jaxon sert à enrichir la classe `Jaxon\Response\Response` avec de nouvelles fonctions.

#### Installation

Pour installer un plugin de réponse Jaxon, il suffit d'installer le package correspondant avec `Composer`.
Une fois installé, le plugin est automatiquement enregistré auprès de la librairie Jaxon, et son code CSS et javascript est automatiquement ajouté à celui de la librairie.

#### Utilisation

Un plugin de réponse de Jaxon possède un nom, qui doit être unique dans toute l'application.
Ce nom permet d'accéder à une instance du plugin à partir d'une instance la classe `Jaxon\Response\Response`.

#### Configuration

Les plugins de réponse sont configurés de la même façon que la librairie Jaxon, à la différence que les noms des paramètres sont préfixés du nom du plugin.

La documentation de chaque plugin fournit la liste de ses paramètres de configuration.

#### Exemple

Le plugin [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) de la version 2 de Jaxon ajoute des notifications à une application, à l'aide de plusieurs libraries javascript dont [Toastr](https://github.com/CodeSeven/toastr).

Pour l'installer, il faut ajouter son package au fichier `composer.json`.

```json
"require": {
    "jaxon-php/jaxon-dialogs": "~3.0"
}
```

Ensuite configurer le package pour utiliser la librairie Toastr.

```php
    $jaxon->setOptions('dialogs.default.alert', 'toastr');
```

Une fois installé et configuré, les fichiers [javascript](https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js) et [css](https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css) de la librairie Toastr sont chargés dans la page HTML, et ses méthodes peuvent être appelées dans les fonctions Jaxon.

```php
class MyClass
{
    public function myMethod()
    {
        $response = new Response;
        $response->dialog->success("You are now using the Toastr Notification plugin!!");
    }
}
```

L'appel `$response->dialog` est l'équivalent de `$response->plugin('dialog')`.
