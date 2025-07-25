---
title: Javascript Callbacks
menu: Js Callbacks
template: jaxon
published: true
---

Jaxon also allows the developer to specify javascript callbacks that will be called at different steps during the execution of the request in the browser.

#### The callback object

A javascript callback is an object containing functions with predefined names, depending on when they are called during the request execution.

```javascript
app.callback.example = {
        onInitialize: function() {
            //
        },
        onProcessParams: function() {
            //
        },
        onPrepare: function() {
            //
        },
        onRequest: function() {
            //
        },
        onResponseDelay: function() {
            //
        },
        onExpiration: function() {
            //
        },
        beforeResponseProcessing: function() {
            //
        },
        onFailure: function() {
            //
        },
        onRedirect: function() {
            //
        },
        onSuccess: function() {
            //
        },
        onComplete: function() {
            //
        },
    }
```

After it is defined, the callback can be associated to one or more Jaxon requests.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'namespace' => 'Ns',
    'classes' => [
        \Ns\App\JaxonExample::class => [
            'functions' => [
                '*' => [
                    'callback' => "app.callback.example"
                ],
                'action' => [
                    'callback' => "app.callback.action"
                ],
            ],
        ],
    ],
]);
```

The javascript callbacks can also be defined in [the configuration file](../../about/configuration.html) or using annotations.

```php
namespace Ns\App;

/**
 * @callback('name' => 'app.callback.example')
 */
class JaxonExample
{
    /**
     * @callback('name' => 'app.callback.action')
     */
    public function action()
    {
    }
}
```

The PHP-DOC syntax can also be used.

```php
namespace Ns\App;

/**
 * @callback app.callback.example
 */
class JaxonExample
{
    /**
     * @callback app.callback.action
     */
    public function action()
    {
    }
}
```

Here's the generated javascript code.

```js
Ns.App.JaxonExample = {};
Ns.App.JaxonExample.action = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.JaxonExample', jxnmthd: 'action' },
        { parameters: arguments, callback: [app.callback.example,app.callback.action] }
    );
};
```

#### The callback functions

The functions in a callback object are called when an Ajax request is sent to one of the classes it is associated to.

###### The `onInitialize` callback

Called before the request object is initialized.
Defined in version 4.0 of the library.

###### The `onProcessParams` callback

Called before the request parameters are processed.
Defined in version 4.0 of the library.

###### The `onPrepare` callback

Called when a request is ready to be submitted.

###### The `onRequest` callback

Called just before the request is actually submitted.

###### The `onResponseDelay` callback

Called if the response delay set in the config expired before the response is received.

###### The `onExpiration` callback

Called if the expiration delay set in the config expired before the response is received.

###### The `beforeResponseProcessing` callback

Called when the response is received, and before it is processed.

###### The `onSuccess` callback

Called when the HTTP response status code indicates a success.

###### The `onRedirect` callback

Called when the HTTP response status code indicates a redirection.

###### The `onFailure` callback

Called when the HTTP response status code indicates a failure.

###### The `onComplete` callback

Called when the response processing request has completed, whether successfully or not.
