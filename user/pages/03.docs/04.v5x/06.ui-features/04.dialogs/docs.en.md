---
title: Dialogs
menu: Dialogs
template: jaxon
---

The [jaxon-dialogs](https://github.com/jaxon-php/jaxon-dialogs) plugin adds the functionality of displaying windows, notifications, and confirmation messages to an application, using various existing Javascript libraries.

It installs with `Composer`.

```json
"require": {
    "jaxon-php/jaxon-dialogs": "~4.0"
}
```

It offers three function groups, described further down this page:
- Dialogs
- Confirmation
- Alerts

It can be configured to use separate JavaScript libraries for each of these functions, but only if the function is supported by the specified library.

In the following example, the [Bootbox](https://bootboxjs.com/), [Toastr](https://codeseven.github.io/toastr/), and [Noty](https://ned.im/noty/) libraries are used to display dialogs, notifications, and confirmation messages, respectively.
The [Alertify](https://alertifyjs.com/) library is also added and can be used on demand.

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

The list of supported Javascript libraries and the functions each provides is available in the [documentation](https://github.com/jaxon-php/jaxon-dialogs).

#### Dialogs

Two functions are provided, to display and to close a dialog window.

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

The `show()` function takes as parameters the window title, its HTML content and an optional array of buttons.

Each button is an array with the following entries:
- `title`: The button's text.
- `class`: A CSS class to apply to the button.
- `click`: The button's click handler. It can be set with a [call factory](../call-factories.html), or set to `close` to close the window.

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

#### Alerts

Four functions are provided, to display different types of notifications in the browser.

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

Each function takes as parameters the message to be displayed, as well as a list of values ​​used to replace placeholders (e.g. `{1}`) in the message.

The `title(string $sTitle)` function, called before one of the previous ones, adds a title to the notification.

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

Placeholders, combined with [call factories](../call-factories.html), can be used to include web page content in messages, and also manage translations.

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

#### Confirm question

The `confirm()` function applies to a call generated with a [call factory](../call-factories.html).
It displays a confirmation message on the screen and executes the call only if the user confirms it.

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

It also accepts a list of values ​​to replace placeholders in the message.

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

#### Specify the library to use

The `with()` method can be used to explicitly indicate the library to use for the next operation.

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

This library must have been added to the plugin configuration.

#### Libraries options

It is possible to specify specific parameters for JavaScript libraries in the dialog plugin configuration.
To do this, add a section with the library identifier to the plugin configuration and define the parameters within this section.

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

The values specified here will be set as the default settings for the library.
