---
title: Migrer de la version 2
menu: Migrer de la version 2
template: jaxon
---

Les principales fonctions à mettre à jour pour migrer de la version 2 sont:

- l'enregistrement des fonctions, des classes et des répertoires
- les callbacks
- la fabrique de requêtes
- la pagination

Si l'application utilise les fonctions des packages `jaxon-armada` et `jaxon-sentry`, il faut y ajouter:

- la classe CallableClass
- le traitement des requêtes

#### Les enregistrements

Bien que l'enregistrement des fonctions et des classes se fasse toujours avec la fonction `register()`, la syntaxe et les paramètres ont changé.

Pour enregistrer une classe, il faut désormais fournir son nom, et plus un objet comme dans la version 2.

Dans la version 2
```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new HelloWorld());
```

Dans la version 3
```php
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class);
```

La fonction `register()` permet désormais d'enregistrer des répertoires.

Dans la version 2
```php
$jaxon->addClassDir('/path/to/first/dir');
$jaxon->addClassDir('/path/to/second/dir', 'Name\\Space');
$jaxon->registerClasses();
```

Dans la version 3
```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/path/to/first/dir');
$jaxon->register(Jaxon::CALLABLE_DIR, '/path/to/second/dir', ['namespace' => 'Name\\Space']);
```

Pour enregistrer une fonction, la syntaxe est différente.

Dans la version 2
```php
$jaxon->register(Jaxon::USER_FUNCTION, 'sayHello');
```

Dans la version 3
```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'sayHello');
```

Pour enregistrer une méthode d'une classe en tant que fonction.

Dans la version 2
```php
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, [$hello, 'sayHello']);
```

Dans la version 3
```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'sayHello', ['class' => HelloWorld::class]);
```

Pour enregistrer une méthode d'une classe avec un alias.

Dans la version 2
```php
$hello = new HelloWorld();
$jaxon->register(Jaxon::USER_FUNCTION, ['helloWorld', $hello, 'sayHello']);
```

Dans la version 3
```php
$jaxon->register(Jaxon::CALLABLE_FUNCTION, 'sayHello', ['class' => HelloWorld::class, 'alias' => 'helloWorld']);
```

#### Les callbacks

Jaxon propose une nouvelle api pour définir les callbacks.

Dans la version 2
```php
$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_BEFORE, 'functionName');

$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_AFTER, 'functionName');

$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_INVALID, 'functionName');

$jaxon->register(Jaxon::PROCESSING_EVENT, Jaxon::PROCESSING_EVENT_ERROR, 'functionName');
```

Dans la version 3
```php
$jaxon->callback()->before(function($target, &$bEndRequest) {});

$jaxon->callback()->after(function($target, $bEndRequest) {});

$jaxon->callback()->invalid(function($sMessage) {});

$jaxon->callback()->error(function($xException) {});
```

Les appels de la version 2 sont dépréciés dans la version 3, et seront supprimés dans une future release.

#### La fabrique de requêtes

Il existe désormais deux fonctions globales, `rq()` et `pr()`, respectivement pour créer les requêtes vers les fonctions ou les classes Jaxon, et leurs paramètres.

Dans la version 2
```php
rq()->call('MyClass.showPage', rq()->select('colorselect'), rq()->page());
```

Dans la version 3
```php
rq('MyClass')->call('showPage', pr()->select('colorselect'), pr()->page());
```

#### La pagination

Une nouvelle syntaxe doit être utilisée pour générer la pagination.

Dans la version 2
```php
$pagination = rq()->paginate($count, $limit, $page, 'MyClass.showPage', rq()->select('colorselect'), rq()->page());
```

Dans la version 3
```php
$pagination = rq('MyClass')->call('showPage', pr()->select('colorselect'), pr()->page())->paginate($page, $limit, $count);
```

#### La classe CallableClass

Dans la version 2, les fonctions avancées (vues, sessions, ...) sont fournies dans les packages `jaxon-armada` et `jaxon-sentry`.
Ces deux packages sont supprimés de la version 3, et leurs fonctions sont incluses dans le package `jaxon-core`.

Pour inclure les fonctions avancées, une classe Jaxon doit désormais hériter de la classe `Jaxon\CallableClass`.

Dans la version 2
```php
class HelloWorld extends \Jaxon\Sentry\Armada
{
    //
}
```

Dans la version 3
```php
class HelloWorld extends \Jaxon\CallableClass
{
    //
}
```

Les méthodes `instance()`, `request()` et `jQuery()` ont été supprimées au profit de leurs versions courtes, `cl()`, `rq()` et `jq()`.

La syntaxe de la pagination a changé.

Dans la version 2
```php
class HelloWorld extends \Jaxon\Sentry\Armada
{
    //
    public function showPage($pageNumber)
    {
        $pagination = $this->pg($itemsTotal, $itemsPerPage, $currentPage)->showPage(rq()->page());
    }
}
```

Dans la version 3
```php
class HelloWorld extends \Jaxon\CallableClass
{
    //
    public function showPage($pageNumber)
    {
        $pagination = $this->rq()->showPage(pr()->page())->paginate($currentPage, $itemsPerPage, $itemsTotal);
    }
}
```

Il faut noter que l'ordre des paramètres a également changé.

#### L'initialisation

Le package `jaxon-armada` permet d'initialiser la librairie Jaxon à partir d'un fichier de configuration.
Dans la version 3, cette fonctionnalité est incluse dans le package `jaxon-core`.

Dans la version 2
```php
$armada = jaxon()->armada();
$armada->config('/path/to/config/file.php');
```

Dans la version 3
```php
$app = jaxon()->app();
$app->setup('/path/to/config/file.php');
```

La syntaxe du fichier de configuration a également changé. Voir [cette section](../../advanced/bootstrap) pour plus d'informations.

#### Le traitement des requêtes

Avec le package `jaxon-armada`, lors du traitement d'une requête Jaxon, il fallait éviter d'appeler la méthode `register()` pour ne pas instancier inutilement toutes les classes qui avaient été enregistrées.

Dans la version 3, cette contrainte n'est plus nécessaire, puisque les classes ne sont plus instanciées au moment de l'enregistrement.

Dans la version 2
```php
$armada = jaxon()->armada();
$armada->config('/path/to/config/file.php');

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

Dans la version 3
```php
$app = jaxon()->app();

// Register classes from config file
$app->setup('/path/to/config/file.php');

if($app->canProcessRequest())
{
    // Process the request
    $app->processRequest();
}
```
