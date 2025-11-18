---
title: Bootstrapping Armada
menu: Bootstrapping
template: jaxon
---

Starting an Armada-based Jaxon application is done in three steps, the second being optional.

First, the configuration must be loaded with the `config()` method, which takes as a parameter the full path to the configuration file.

Then, the actions to be executed at different stages of the request processing are defined using callbacks.
This step is optional. The callbacks are described below.

Finally, the classes are registered or the request is processed, depending on the action performed on the webpage.

```php
$armada = jaxon()->armada();

// 1. Configuration
$armada->config('/path/to/config.php');

// 2. Callbacks
$armada->onInit(function($instance){
    $instance->init();
});

// 3. Process classes or request
if($armada->canProcessRequest())
{
    // Process the request
    $armada->processRequest();
}
else
{
    // Register the classes
    $armada->register();
}
```

#### The configuration

The configuration of Armada is loaded from a file, which can be in PHP, YAML or JSON format.
It has two main sections, identified with the `app` and` lib` keywords.

The `lib` section contains the [configuration options of the libraries](/docs/usage/configuration), and its plugins.
The `app` section contains the [configuration options of the classes](/docs/armada/classes) and [those of the views](/docs/armada/views).

#### The callbacks

When using Armada, les [callbacks](/docs/responses/callbacks) are not registered with the `jaxon()->register()` function anymore.
They must be defined with anonymous functions and the following methods, which give the developer access to the invoked object and method.

###### Library initialization

```php
$armada->onInit(function($instance){
    // Your code here
});
```

###### Before processing the request

```php
$armada->onBefore(function($instance, $method, &$bEndRequest){
    // Your code here
});
```

###### After processing the request

```php
$armada->onAfter(function($instance, $method){
    // Your code here
});
```

###### On invalid request

```php
$armada->onInvalid(function($response, $message){
    // Your code here
});
```

###### On error

```php
$armada->onError(function($response, $exception){
    // Your code here
});
```

The `$instance` and `$method` parameters are respectively the instance of the invoked class and the name of the invoked method.
The `$bEndRequest` parameter is a boolean which can be set to `true` in the callback to stop the ongoing request processing.
The `Response` object is either available in the object attribute `$instance->response`, or passed as a parameter to the callback.
In case of an invalid request, the `$message` parameter indicates the cause, and in case of an error, the `$exception` parameter is the exception which was thrown.

