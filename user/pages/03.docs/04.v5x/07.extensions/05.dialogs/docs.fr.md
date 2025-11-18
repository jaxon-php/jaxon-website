---
title: Les extensions de dialogue
menu: Les extensions de dialogue
template: jaxon
---

Le [plugin Dialogs](../../ui-features/dialogs.html) est un cas spéciial dans l'univers Jaxon. C'est un [plugin de réponse](../response.html), mais qui peut ête étendu avec ses propres plugins.

Une extension de dialogue connecte une librairie de dialogue tierce à la librairie Jaxon.
Elle doit étendre la classe `Jaxon\Dialogs\Dialog\AbstractLibrary`, et selon les fonctions que la librairie tierce offre, elle doit implémenter une ou plusieurs parmi les interfaces suivantes:
- `Jaxon\App\Dialog\Library\AlertInterface`
- `Jaxon\App\Dialog\Library\ConfirmInterface`
- `Jaxon\App\Dialog\Library\ModalInterface`

Ces trois interfaces ne contiennent pas de fonctions, et servent uniquement à indiquer les fonctionnalités de la librairie tierce.

La classe `Jaxon\Dialogs\Dialog\AbstractLibrary` définit des fonctions que l'extension doit implémenter ou personnaliser pour intialiser la librairie.

La fonction `public function getName(): string` retourne un nom unique pour la librairie.
Les fonctions `public function getJs(): string`, `public function getCss(): string`, `public function getScript(): string`, et `public function getJsCode(): ?JsCode` sont les fonctions usuelles de génération de code.

Alternativement, la fonction `public function getUri(): string` peut définir une URL de base, tandis que les attributs `protected $aCssFiles` et `protected $aJsFiles` définissent des fichiers à charger à partir de cette URL.

Une fois définie, l'extension doit être déclarée dans le plugin `Dialogs` avec l'appel suivant.

```php
jaxon()->plugin(Jaxon\Dialogs\DialogPlugin::class)->registerLibrary($sClassName, $sLibraryName);
```

#### Le code Javascript

L'intégration avec le code de la librairie intégrée se fait uniquement dans le code Javascript, qui doit donc également être chargé par la librairie PHP.
Pour les librairies intégrées dans le [package Dialogs](https://github.com/jaxon-php/jaxon-dialogs), les fichiers Javascript sont chargés depuis le CDN Github.

```js
jaxon.dom.ready(() => jaxon.dialog.register('<library_name>', (self, options, utils) => {
    // Dialogs options
    const {
        labels,
        modal: modalOptions = {},
        alert: alertOptions = {},
        confirm: confirmOptions = {},
    } = options;

    // Initialize the dialog library
    ...

    /**
     * Show the modal dialog
     *
     * @param {object} dialog The dialog parameters
     * @param {string} dialog.title The dialog title
     * @param {string} dialog.content The dialog HTML content
     * @param {array} dialog.buttons The dialog buttons
     * @param {array} dialog.options The dialog options
     * @param {function} cbDomElement A callback to call with the DOM element of the dialog content
     *
     * @returns {object}
     */
    self.show = ({ title, content, buttons, options }, cbDomElement) => {
        //
    };

    /**
     * Hide the modal dialog
     *
     * @returns {void}
     */
    self.hide = () => {
        //
    };

    /**
     * Show an alert message
     *
     * @param {object} alert The alert parameters
     * @param {string} alert.type The alert type
     * @param {string} alert.message The alert message
     *
     * @returns {void}
     */
    self.alert = ({ type, message }) => {
        //
    };

    /**
     * Ask a confirm question to the user.
     *
     * @param {object} confirm The confirm parameters
     * @param {string} confirm.question The question to ask
     * @param {string} confirm.title The question title
     * @param {object} callback The confirm callbacks
     * @param {callback} callback.yes The function to call if the answer is yes
     * @param {callback=} callback.no The function to call if the answer is no
     *
     * @returns {void}
     */
    self.confirm = ({ question, title }, { yes: yesCb, no: noCb = () => {} }) => {
        //
    };
}));
```

Le nom de la librairie doit être le même que celui indiqué dans le code PHP.
Le paramètre `self` est l'instance de la librairie.
Le paramètre `options` contient les options passées à la [configuration de la librairie](../../ui-features/dialogs.html).
Le paramètre `utils` est un objet qui contient des fonctions utilitaires.

La callback retourne un objet qui doit implémenter certaines méthodes, selon les fonctions de la librairie tierce.

Fenêtres modales:
- `show()`
- `hide()`

Messages d'alertes:
- `alert()`

Question de confirmation:
- `confirm()`
