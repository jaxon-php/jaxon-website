---
title: Response plugins
menu: Response plugins
template: jaxon
---

A Jaxon Response plugin extends the `Jaxon\Response\Response` class with new functions.
It has a name that must be unique throughout the application and can be used as an attribute of the `Response` object to get access to its instance.

#### Create a response plugin

Like all others, a response plugin must first implement the `Jaxon\Plugin\PluginInterface` interface.
If it generates code, it must also implement the `Jaxon\Plugin\CodeGeneratorInterface` interface.
Finally, it must implement the `Jaxon\Plugin\ResponsePluginInterface` interface, which defines the functions to initialize its instance with the `Response` object it is attached to.

```php
namespace Jaxon\Plugin;

use Jaxon\Response\AbstractResponse;

interface ResponsePluginInterface
{
    /**
     * Get the attached response
     *
     * @return AbstractResponse|null
     */
    public function response(): ?AbstractResponse;

    /**
     * @param AbstractResponse $xResponse   The response
     *
     * @return static
     */
    public function initPlugin(AbstractResponse $xResponse): static;
}
```

Alternatively, the plugin can extend the `Jaxon\Response\AbstractResponsePlugin` class, which already includes the three interfaces above and implements the `initPlugin()` function and default functions for code generation.
The plugin can then override the `protected function init(): void` function for its initialization.

#### Register a response plugin

Once defined, the plugin must be registered with the Jaxon library, with the following call.

```php
jaxon()->registerPlugin($sClassName, $sPluginName, $nPriority);
```

The `$sPluginName` variable must have the same value as the one returned by the `getName()` method.
For third-party plugins, the `$nPriority` parameter should be set to a value greater than 1000.

The plugin's CSS and Javascript code will then be added to the library's code and included in the web pages.

#### How a response plugin works

Each plugin method can use the `addCommand()` method of the `Response` object to add commands to be executed in the browser.
If it inherits from the `Jaxon\Response\AbstractResponsePlugin` class, then it has the `addCommand()` method, which also adds the `plugin` option to the command.

```php
    public function addCommand(string $sName, array|JsonSerializable $aOptions): Command
    {
        return $this->xResponse
            ->addCommand($sName, $aOptions)
            ->setOption('plugin', $this->getName());
    }
```

For example, the `DataBag` plugin uses the following call to add the list of changed values to the response.

```php
    if($this->xDataBag->touched())
    {
        $this->addCommand('databag.set', ['values' => $this->xDataBag]);
    }
```

A plugin function can add multiple commands to the response.
For commands that require more complex Javascript functions, it may be more convenient to create a new command in the Javascript library and call it in the PHP code.
For example, the [Flot](https://github.com/jaxon-php/jaxon-flot) plugin defines a command in [its Javascript code](https://github.com/jaxon-php/jaxon-flot/blob/main/js/flot.js).

```js
jaxon.dom.ready(function() {
    jaxon.register("flot.plot", function({ plot }) {
        // Draw the plot
        ...
        return true;
    });
});
```

In [its PHP code](https://github.com/jaxon-php/jaxon-flot/blob/main/src/FlotPlugin.php), it defines this function,

```php
    /**
     * Draw a Plot in a given HTML element.
     *
     * @return void
     */
    public function draw(Plot $xPlot)
    {
        $this->addCommand('flot.plot', ['plot' => $xPlot]);
    }
```

which is then used, [as in the example](https://github.com/jaxon-php/jaxon-examples/blob/main/examples/flot/code.php), to display a graph.

```php
    public function drawGraph()
    {
        $flot = $this->response()->plugin(FlotPlugin::class);
        // Create a new plot, to be displayed in the div with id "flot"
        $plot = $flot->plot('#flot')->width('450px')->height('300px');
        // Fill the graph
        ...
        // Draw the graph
        $flot->draw($plot);
    }
```

As in the example above, the name of a response plugin gives access to its instance from an instance of the `Jaxon\Response\Response` class.
For example, the instance of the `FlotPlugin` plugin, whose name is `flot`, can be retrieved by calling `$response->flot`, or `$response->plugin('flot')`, or by using the class name.

```php
$response->plugin(Jaxon\Flot\FlotPlugin::class);
```
