---
title: Request plugins
menu: Request plugins
template: jaxon
---

A request plugin adds new object types to be registered, in addition to classes and functions, into the library.
When an object of the defined type is declared in the library, the request plugin generates the corresponding Javascript code and then handles Ajax requests sent to the object.

#### Create a request plugin

Like all others, a request plugin must first implement the `Jaxon\Plugin\PluginInterface` interface.
If it generates code, it can also implement the `Jaxon\Plugin\CodeGeneratorInterface` or `Jaxon\Plugin\CodeGeneratorInterface` interface.

It must then implement at least one of the following two interfaces.
The `Jaxon\Plugin\CallableRegistryInterface` interface, which defines functions for declaring objects to be called in Jaxon requests, or the `Jaxon\Plugin\RequestHandlerInterface` interface, which defines functions for handling Jaxon requests.

```php
namespace Jaxon\Plugin;

interface CallableRegistryInterface
{
    /**
     * Check if the provided options are correct, and convert them into an array.
     *
     * @param string $sCallable
     * @param mixed $xOptions
     *
     * @return array
     */
    public function checkOptions(string $sCallable, $xOptions): array;

    /**
     * Register a callable entity: a function or a class.
     *
     * Called by the <Jaxon\Plugin\RequestManager> when a user script
     * when a function or callable object is to be registered.
     * Additional plugins may support other registration types.
     *
     * @param string $sType    The type of request handler being registered
     * @param string $sCallable    The callable entity being registered
     * @param array $aOptions    The associated options
     *
     * @return bool
     */
    public function register(string $sType, string $sCallable, array $aOptions): bool;

    /**
     * Get the callable object for a registered item
     *
     * @param string $sCallable
     *
     * @return mixed
     */
    public function getCallable(string $sCallable);
}
```

The `checkOptions()` function checks whether the options passed to the `jaxon()->register()` call or in the configuration are correct.
The `register()` function is called every time `jaxon()->register()` is called, and it will return the boolean value `true` if the declared object is of the type supported by the plugin.
The `getCallable()` function returns a `Callable` object that provides request processing functions.

```php
namespace Jaxon\Plugin;

use Jaxon\Request\Target;
use Psr\Http\Message\ServerRequestInterface;

interface RequestHandlerInterface
{
    /**
     * Get the target function or class and method
     *
     * @return Target|null
     */
    public function getTarget(): ?Target;

    /**
     * @param ServerRequestInterface $xRequest
     *
     * @return Target
     */
    public function setTarget(ServerRequestInterface $xRequest): Target;

    /**
     * Check if this plugin can process the current request
     *
     * Called by the <Jaxon\Plugin\RequestManager> when a request has been received to determine
     * if the request is targeted to this request plugin.
     *
     * @param ServerRequestInterface $xRequest
     *
     * @return bool
     */
    public static function canProcessRequest(ServerRequestInterface $xRequest): bool;

    /**
     * Process the current request
     *
     * Called by the <Jaxon\Plugin\RequestManager> when a request is being processed.
     * This will only occur when <Jaxon> has determined that the current request
     * is a valid (registered) jaxon enabled function via <jaxon->canProcessRequest>.
     *
     * @return void
     */
    public function processRequest();
}
```

The static function `canProcessRequest()` detects whether an incoming request can be processed by the plugin.
The `processRequest()` function actually processes the request.
During processing, the `setTarget()` and `getTarget()` functions set and retrieve information about the request target, respectively.

#### Register a request plugin

A request plugin must be registered with the library.

```php
jaxon()->registerPlugin($sClassName, $sPluginName, $nPriority);
```

The `$sPluginName` variable must have the same value as the one returned by the `getName()` method.
For third-party plugins, the `$nPriority` parameter should be set to a value greater than 1000.

The plugin's CSS and Javascript code will then be added to the library's code and included in the web pages.
