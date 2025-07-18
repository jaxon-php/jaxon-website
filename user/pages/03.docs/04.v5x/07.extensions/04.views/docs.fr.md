---
title: Les extensions de vues
menu: Les extensions de vues
template: jaxon
---

Jaxon propose [une API d'affichage des vues](../../ui-features/views.html) générique, qui peut s'adapter à divers moteurs de templates.
Une extension de vues connecte un moteur de templates à cette API.

#### Créer une extension de vues

Une extension de vues doit implémenter l'interface `Jaxon\App\View\ViewInterface`.

```php
namespace Jaxon\App\View;

interface ViewInterface
{
    /**
     * Add a namespace to the view renderer
     *
     * @param string $sNamespace    The namespace name
     * @param string $sDirectory    The namespace directory
     * @param string $sExtension    The extension to append to template names
     *
     * @return void
     */
    public function addNamespace(string $sNamespace, string $sDirectory, string $sExtension = '');

    /**
     * Render a view
     *
     * @param Store $store    A store populated with the view data
     *
     * @return string
     */
    public function render(Store $store): string;
}
```

La fonction `addNamespace()` déclare un répertoire de templates dans le moteur, en lui associant un namespace et optionnellement une extension.
La fonction `render()` affiche une vue à partir des paramètres stockés dans un objet `Jaxon\App\View\Store`, qui contient son nom, son namespace, et tous les paramètres qui lui ont été passés.

L'extension doit être déclarée auprès de la librairie, en lui passant son id, et une callback qui l'instancie.
Par exemple, l'extension [Twig](https://github.com/jaxon-php/jaxon-twig) est déclarée avec l'appel suivant.

```php
jaxon()->di()->getViewRenderer()->addRenderer('twig', function () {
    return new Jaxon\Twig\View();
});
```

#### Les fonctions de template

Une extension de vues peut également ajouter dans le moteur de templates des fonctions pour [insérer le code généré](../../registrations/javascript.html), les [composants d'UI](../../components/node-components.html), ou les [call factories](../../ui-features/call-factories.html).
Ce sont généralement les fonctions suivantes.

Génération de code.
- jxnCss(): insère le code CSS de la librairie.
- jxnJs(): insère le code Javascript de la librairie.
- jxnScript(): insère le code des exports de la librairie.

Gestion des composants d'UI.
- jxnBind(): attache un composant à un élément du DOM.
- jxnHtml(): insère le code HTML d'un composant.
- jxnPagination(): attache un composant de pagination à un élément du DOM.

Gestionnaires d'évènements.
- jxnOn(): définit un gestionnaire d'évènements.
- jxnClick(): définit un gestionnaire pour l'évènement `click`.
- jxnEvent(): définit des gestionnaires d'évènements.
- rq(): `call factory` pour un objet exporté.
- jo(): `call factory` pour un objet Javascript.
- jq(): `call factory` pour un sélecteur jQuery.
- je(): `call factory` pour un sélecteur Javascript.
