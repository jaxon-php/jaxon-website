---
title: Dialog extensions
menu: Dialog extensions
template: jaxon
---

The [Dialogs plugin](../../ui-features/dialogs.html) is a special case in the Jaxon universe. It is a [response plugin](../response.html), but can be extended with its own plugins.

A dialog extension connects a third-party dialog library to the Jaxon library.
It must extend the `Jaxon\Dialogs\Dialog\AbstractLibrary` class, and depending on the functions the third-party library provides, it must implement one or more of the following interfaces:
- `Jaxon\App\Dialog\Library\AlertInterface`
- `Jaxon\App\Dialog\Library\ConfirmInterface`
- `Jaxon\App\Dialog\Library\ModalInterface`

These three interfaces do not contain functions and are used only to specify the functionality of the third-party library.

The `Jaxon\Dialogs\Dialog\AbstractLibrary` class defines functions that the extension must implement or customize to initialize the library.

The `public function getName(): string` function returns a unique name for the library.
The `public function getJs(): string`, `public function getCss(): string`, `public function getScript(): string`, and `public function getJsCode(): ?JsCode` functions are the usual code generation functions.

Alternatively, the `public function getUri(): string` function can define a base URL, while the `protected $aCssFiles` and `protected $aJsFiles` attributes define the files to load from that URL.

Once defined, the extension must be declared in the `Dialogs` plugin with the following call.

```php
jaxon()->plugin(Jaxon\Dialogs\DialogPlugin::class)->registerLibrary($sClassName, $sLibraryName);
```

#### The Javascript code

Integration with the third-party library code is done only in the Javascript code, which must then be also loaded by the PHP library.
For the libraries integrated in the [Dialogs package](https://github.com/jaxon-php/jaxon-dialogs), the Javascript files are loaded from the Github CDN.

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

The library name must be the same as the one specified in the PHP code.
The `self` parameter is the library instance.
The `options` parameter contains the options passed to the [library configuration](../../ui-features/dialogs.html).
The `utils` parameter is an object containing utility functions.

The callback returns an object that must implement certain methods, depending on the third-party library features.

Modal windows:
- `show()`
- `hide()`

Alert messages:
- `alert()`

Confirmation question:
- `confirm()`
