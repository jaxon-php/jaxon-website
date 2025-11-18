---
title: Les plugins de réponse
menu: Les plugins de réponse
template: jaxon
---

Un plugin de réponse de Jaxon enrichit la classe `Jaxon\Response\Response` avec de nouvelles fonctions.
Il possède un nom qui doit être unique dans toute l'application, et qui peut ête utilisé comme attribut de l'objet `Response` pour accéder à son instance.

#### Créer un plugin de réponse

Comme tous les autres, un plugin de réponse doit d'abord implémenter l'interface `Jaxon\Plugin\PluginInterface`.
S'il génère du code, il doit également implémenter l'interface `Jaxon\Plugin\CodeGeneratorInterface`.
Il doit enfin implémenter l'interface `Jaxon\Plugin\ResponsePluginInterface`, qui définit les fonctions pour initialiser son instance avec l'objet `Response` auquel il est attaché.

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

Alternativement, le plugin peut étendre la classe `Jaxon\Response\AbstractResponsePlugin`, qui inclut déjà les trois interfaces ci-dessus, et implémente la fonction `initPlugin()` et des fonctions par défaut pour la génération de code.
Le plugin peut alors redéfinir la fonction `protected function init(): void` pour son initialisation.

#### Déclarer un plugin de réponse

Une fois défini, le plugin doit être enregistré auprès de la librairie Jaxon, avec l'appel suivant.

```php
jaxon()->registerPlugin($sClassName, $sPluginName, $nPriority);
```

La variable `$sPluginName` doit avoir la même valeur que celle renvoyée par la méthode `getName()`.
Pour des plugins tiers, il convient de donner une valeur supérieure à 1000 au paramètre `$nPriority`.

Le code CSS et Javascript du plugin sera alors ajouté à celui de la librairie et inclus dans les pages web.

#### Fonctionnement d'un plugin de réponse

Chaque méthode du plugin peut utiliser la méthode `addCommand()` de l'objet `Response` pour ajouter des commandes à exécuter dans le navigateur.
S'il hérite de la classe `Jaxon\Response\AbstractResponsePlugin`, alors il dispose de la méthode `addCommand()`, qui en plus ajoute l'option `plugin` à la commande.

```php
    public function addCommand(string $sName, array|JsonSerializable $aOptions): Command
    {
        return $this->xResponse
            ->addCommand($sName, $aOptions)
            ->setOption('plugin', $this->getName());
    }
```

Par exemple, le plugin `DataBag` utilise l'appel suivant ajouter la liste des valeurs modifiées à la réponse.

```php
    if($this->xDataBag->touched())
    {
        $this->addCommand('databag.set', ['values' => $this->xDataBag]);
    }
```

Une fonction d'un plugin peut ajouter plusieurs commandes à la réponse.
Pour les commandes qui requièrent des fonctions Javascript plus complexes, il peut être plus intéressant de créer une nouvelle commande dans la librairie Javascript, et de l'appeler dans le code PHP.
Par exemple, le plugin [Flot](https://github.com/jaxon-php/jaxon-flot) définit ainsi une commande dans [son code Javascript](https://github.com/jaxon-php/jaxon-flot/blob/main/js/flot.js).

```js
jaxon.dom.ready(function() {
    jaxon.register("flot.plot", function({ plot }) {
        // Draw the plot
        ...
        return true;
    });
});
```

Dans [son code PHP](https://github.com/jaxon-php/jaxon-flot/blob/main/src/FlotPlugin.php), elle définit cette fonction,

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

qui est ensuite utilisée, [comme dans l'exemple](https://github.com/jaxon-php/jaxon-examples/blob/main/examples/flot/code.php), pour afficher un graphe.

```php
    public function drawGraph()
    {
        $flot = $this->response->plugin(FlotPlugin::class);
        // Create a new plot, to be displayed in the div with id "flot"
        $plot = $flot->plot('#flot')->width('450px')->height('300px');
        // Fill the graph
        ...
        // Draw the graph
        $flot->draw($plot);
    }
```

Comme dans l'exemple ci-dessus, le nom d'un plugin de réponse donne accès à son instance à partir d'une instance la classe `Jaxon\Response\Response`.
Par exemple, l'instance du plugin `FlotPlugin`, dont le nom est `flot`, peut être retrouvé par l'appel `$response->flot`, ou `$response->plugin('flot')`, ou avec le nom de la classe.

```php
$response->plugin(Jaxon\Flot\FlotPlugin::class);
```
