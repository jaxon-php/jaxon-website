---
title: Les plugins de requête
menu: Les plugins de requête
template: jaxon
---

Un plugin de requête ajoute à la librairie de nouveaux types d'objets à enregistrer, en plus des classes et des fonctions.
Lorsqu'un object du type défini est déclaré dans la librairie, le plugin de requête génère le code Javascript correspondant, et va ensuite traiter les requêtes Ajax envoyées vers l'objet.

#### Créer un plugin de requête

Comme tous les autres, un plugin de requête doit d'abord implémenter l'interface `Jaxon\Plugin\PluginInterface`.
S'il génère du code, il doit également implémenter l'interface `Jaxon\Plugin\CodeGeneratorInterface`.

Il doit ensuite implémenter au moins l'une des deux interfaces suivantes.
L'interface `Jaxon\Plugin\CallableRegistryInterface`, qui définit les fonctions pour déclarer les objets à appeler dans les requêtes Jaxon, ou l'interface `Jaxon\Plugin\RequestHandlerInterface`, qui définit les fonctions pour traiter des requêtes Jaxon.

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

La fonction `checkOptions()` vérifie si les options passées à l'appel à `jaxon()->register()` ou dans la configuration sont corrects.
La fonction `register()` est appelée à chaque appel à `jaxon()->register()`, et elle renverra la valeur booléenne `true` l'objet déclaré est du type que le plugin supporte.
La fonction `getCallable()` renvoie un objet `Callable` qui offre les fonctions de traitement de la requête. 

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

La fonction statique `canProcessRequest()` détecte si une requête entrante peut être traitée par le plugin.
La fonction `processRequest()` traite effectivement la requête.
Lors du traitement, les fonctions `setTarget()` et `getTarget()` permettent respectivement de définir et retrouver des informations sur la cible de la requête.

#### Déclarer un plugin de requête

Un plugin de requête doit être déclaré auprès de la librairie.

```php
jaxon()->registerPlugin($sClassName, $sPluginName, $nPriority);
```

La variable `$sPluginName` doit avoir la même valeur que celle renvoyée par la méthode `getName()`.
Pour des plugins tiers, il convient de donner une valeur supérieure à 1000 au paramètre `$nPriority`.

Le code CSS et Javascript du plugin sera alors ajouté à celui de la librairie et inclus dans les pages web.
