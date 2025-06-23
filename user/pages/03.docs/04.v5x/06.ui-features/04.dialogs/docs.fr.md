---
title: Les dialogues
menu: Les dialogues
template: jaxon
---

Le plugin [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) ajoute les fonctions d'affichage de fenêtres, de notifications et de messages de confirmation dans une application, avec différentes librairies Javascript existantes.

Il s'installe avec `Composer`.

```json
"require": {
    "jaxon-php/jaxon-dialogs": "~5.0"
}
```

Il offre trois groupes fonctions, décrites plus bas dans cette page:
- Dialogues
- Confirmation
- Alertes

Il peut être configuré pour utiliser des librairies Javascript distinctes pour chacune de ces fonctions, mais à condition que la fonction soit supportée par la librairie indiquée.

Dans l'exemple suivant, les librairies [Bootbox](https://bootboxjs.com/), [Toastr](https://codeseven.github.io/toastr/) et [Noty](https://ned.im/noty/) sont utilisées respectivement pour afficher les fenêtres de dialogues, les notifications et les messages de confirmation.
La librairie [Alertify](https://alertifyjs.com/) est ajoutée en plus, et pourra être utilisée à la demande.

```php
    'app' => [
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'toastr',
                'confirm' => 'noty',
            ],
            'lib' => [
                'use' => ['alertify'],
            ],
        ],
    ],
```

```php
    jaxon()->setAppOptions([
        'default' => [
            'modal' => 'bootbox',
            'alert' => 'toastr',
            'confirm' => 'noty',
        ],
        'lib' => [
            'use' => ['alertify'],
        ],
    ], 'dialogs');
```

La liste des librairies Javascript supportées et des fonctions que chacune fournit est disponible dans la [documentation](https://github.com/jaxon-php/jaxon-dialogs).

#### Dialogues

Deux fonctions sont fournies, pour afficher et pour fermer une fenêtre de dialogue.

```php
/**
 * Show a modal dialog.
 */
public function show(string $title, string $content, array $buttons = [], array $options = []);

/**
 * Hide the modal dialog.
 */
public function hide();
```

La fonction `show()` prend en paramètres le titre de la fenêtre, son contenu HTML et un optionnel tableau de boutons.

Chaque bouton est un tableau avec les entrées suivantes:
- `title`: le texte du bouton.
- `class`: une classe CSS à appliquer au bouton.
- `click`: le gestionnaire du click sur le bouton. Il peut être défini avec une [call factory](../call-factories.html), ou avoir la valeur `close` pour fermer la fenêtre.

```php
class MyClass
{
    public function showDialog()
    {
        // The HTML content of the dialog
        $content = '<form id="data-form">...</form>';
        // The dialog buttons
        $buttons = [[
            'title' => 'Close',
            'class' => 'btn',
            'click' => 'close'
        ], [
            'title' => 'Save',
            'class' => 'btn',
            'click' => $this->rq()->save(pm()->form('data-form'));
        ]];
        // Show the dialog
        $this->response->dialog->show("Modal Dialog", $content, $buttons);
    }

    public function save(array $dataFormValues)
    {
    }
}
```

#### Alertes

Quatre fonctions sont fournies, pour afficher différents types de notifications dans le navigateur.

```php
    /**
     * Show a success message.
     *
     * @param string $sMessage  The text of the message
     *
     * @return void
     */
    public function success(string $sMessage, ...$aArgs);

    /**
     * Show an information message.
     *
     * @param string $sMessage  The text of the message
     *
     * @return void
     */
    public function info(string $sMessage, ...$aArgs);

    /**
     * Show a warning message.
     *
     * @param string $sMessage  The text of the message
     *
     * @return void
     */
    public function warning(string $sMessage, ...$aArgs);

    /**
     * Show an error message.
     *
     * @param string $sMessage  The text of the message
     *
     * @return void
     */
    public function error(string $sMessage, ...$aArgs);
```

Chaque fonction prend en paramètres le message à afficher, ainsi qu'une liste de valeurs servant à remplacer les placeholders (par exempe `{1}`) dans le message.

La fonction `title(string $sTitle)`, appelée avant l'une des précédentes, ajoute un titre à la notification.

```php
class MyClass
{
    public function myMethod()
    {
        $this->response->dialog
            ->title('Greetings')
            ->success("Hello Mr Johnson!!");
    }
}
```

Les placeholders, combinés aux [call factories](../call-factories.html), permettent d'inclure le contenu de la page web dans les messages, et aussi de gérer les traductions.

```php
class MyClass
{
    public function myMethod()
    {
        $this->response->dialog
            ->title('Greetings')
            ->success("Hello {1}!!", rq('#fullname')->html());
    }
}
```

#### Confirmation

La fonction `confirm()` s'applique à un appel généré avec une [call factory](../call-factories.html).
Elle affiche un message de confirmation à l'écran, et exécute l'appel uniquement si l'utilisateur le confirme.

```php
    /**
     * Add a confirm question to a function call.
     *
     * @param string $sQuestion
     *
     * @return array
     */
    public function confirm(string $sQuestion, ...$aArgs);
```

Elle accepte également une liste de valeurs pour remplacer les placeholders dans le message.

```php
class MyClass
{
    public function showDialog()
    {
        // The HTML content of the dialog
        $content = '<form id="data-form">...</form>';
        // The dialog buttons
        $buttons = [[
            'title' => 'Close',
            'class' => 'btn',
            'click' => 'close'
        ], [
            'title' => 'Save',
            'class' => 'btn',
            'click' => $this->rq()->save(pm()->form('data-form'))
                ->confirm('Hey {1}, do you confirm?', rq('#fullname')->html());
        ]];
        // Show the dialog
        $this->response->dialog->show("Modal Dialog", $content, $buttons);
    }

    public function save(array $dataFormValues)
    {
    }
}
```

#### Indiquer la librairie à utiliser

La méthode `with()` permet d'indiquer explicitement la librairie à utiliser pour la prochaine opération.

```php
class MyClass
{
    public function myMethod()
    {
        $this->response->dialog
            ->with('alertify')
            ->info("You are now using the Alertify notification library!!");
    }
}
```

Cette librairie doit avoir été ajoutée à la configuration du plugin.

#### Options des librairies

Il est possible d'indiquer dans la configuration du plugin de dialogue des paramètres spécifiques aux librairies Javascript.
Pour cela, il faut ajouter à la configuration du plugin une section avec l'identifiant de la librairie, et définir les paramètres à l'intérieur de cette section.

```php
    'app' => [
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'toastr',
                'confirm' => 'noty',
            ],
            'toastr' => [
                'options' => [
                    'alert' => [
                        'closeButton' => true,
                        'closeDuration' => 0,
                        'positionClass' => 'toast-top-center',
                    ],
                ],
            ],
        ],
    ],
```

Les valeurs indiquées ici seront définies comme paramètres par défaut de la librairie.
