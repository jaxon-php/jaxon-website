---
title: Comment ça marche
menu: Comment ça marche
template: jaxon
---

L'objectif du Module est de simplifier l'utilisation de Jaxon, tout en l'enrichissant fonctionnellement.

Avec le Module, une application Jaxon démarre à partir d'un fichier de configuration, et ses [classes](/docs/module/controller) héritent automatiquement d'un riche ensemble de fonctions.

Le Module fournit une API commune à tous les modules d'intégration de frameworks, avec des fonctions de gestion des [sessions](/docs/module/session) et des [vues](/docs/module/view).
Une classe Jaxon écrite pour le module devrait fonctionner sur n'importe quel framework avec un minimum, voire pas de changement, permettant ainsi de créer des packages PHP complets et multi-framework.  
Par contre, il permet d'exporter uniquement des classes avec un namespace, et pas des fonctions PHP.

#### Le démarrage

Le démarrage d'une application basée sur le Module de Jaxon est simple.
Il suffit de charger la configuration, puis d'enregistrer les classes ou de traiter la requête reçue.  
Le comportement de l'application est entièrement défini par sa configuration.

```php
$jaxon = jaxon()->module();
$jaxon->config('/path/to/config.php');

if($jaxon->canProcessRequest())
{
    // Process the request
    $jaxon->processRequest();
}
else
{
    // Register the classes
    $jaxon->register();
}
```

#### Les callbacks

Avec le Module de Jaxon, les [callbacks](/docs/responses/callbacks) ne doivent plus être définies avec la fonction `register()`.
Elles doivent être définies à l'aide de fonctions anonymes et des méthodes suivantes, qui donnent au développeur l'accès au contrôleur et à la méthode appelés.

###### Initialisation de la librairie

```php
jaxon()->module()->onInit(function($controller){
    // Your code here
});
```

###### Avant le traitement de la requête

```php
jaxon()->module()->onBefore(function($controller, $method, &$bEndRequest){
    // Your code here
});
```

###### Après le traitement de la requête

```php
jaxon()->module()->onAfter(function($controller, $method){
    // Your code here
});
```

###### En cas de requête invalide

```php
jaxon()->module()->onInvalid(function($response, $message){
    // Your code here
});
```

###### En cas d'erreur

```php
jaxon()->module()->onError(function($response, $exception){
    // Your code here
});
```

Les paramètres `$controller` et `$method` sont respectivement l'instance de la classe Jaxon et le nom de la méthode invoquées.
le paramètre `$bEndRequest` est un booléen que l'on peut passer à `true` dans la callback pour interrompre la requête en cours.
Un objet `Response` est soit accessible dans le contrôleur avec `$controller->response`, soit passé en paramètre à la callback.
En cas de requête invalide, le paramètre `$message` décrit l'erreur, et en cas d'erreur, le paramètre `$exception` est l'exception qui a été levée.

#### La configuration

La configuration du Module est chargé à partir d'un fichier, qui peut être au format PHP, YAML ou JSON.
Elle comporte deux sections principales, identifiées avec les mots-clés `app` et `lib`.

La section `lib` contient les [paramètres de la librairie](/docs/usage/configuration), et de ses plugins.
La section `app` contient les paramètres du module proprement dit, qui comprend la [configuration des contrôleurs](/docs/module/controller) et [celle des vues](/docs/module/view).
