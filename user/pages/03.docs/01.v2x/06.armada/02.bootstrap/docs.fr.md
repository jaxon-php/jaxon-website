---
title: Le démarrage de Armada
menu: Le démarrage
template: jaxon
---

Le démarrage d'une application Jaxon basée sur Armada se fait en trois étapes, la seconde étant optionnelle.

D'abord il faut définir la configuration avec la méthode `config()`, qui prend en paramètre le chemin complet vers le fichier de configuration.

Ensuite, il faut définir à l'aide de callbacks les actions à exécuter à différentes étapes du traitement de la requête.
Cette étape est optionnelle. Les callbacks sont présentées ci-dessous.

Enfin, il faut soit exporter les classes ou traiter la requête, selon l'action exécutée sur la page web.  

```php
$armada = jaxon()->armada();

// 1. Configuration
$armada->config('/path/to/config.php');

// 2. Callbacks
$armada->onInit(function($instance){
    $instance->init();
});

// 3. Traiter les classes ou la requête
if($armada->canProcessRequest())
{
    // Traiter la requête
    $armada->processRequest();
}
else
{
    // Exporter les classes
    $armada->register();
}
```

#### La configuration

La configuration de Armada est chargé à partir d'un fichier, qui peut être au format PHP, YAML ou JSON.
Elle comporte deux sections principales, identifiées avec les mots-clés `app` et `lib`.

La section `lib` contient la [configuration de la librairie](/docs/usage/configuration), et de ses plugins.
La section `app` contient la [configuration des classes](/docs/armada/classes) et [celle des vues](/docs/armada/views).

#### Les callbacks

Avec Armada, les [callbacks](/docs/responses/callbacks) ne doivent plus être définies avec la fonction `jaxon()->register()`.
Elles doivent être définies à l'aide de fonctions anonymes et des méthodes suivantes, qui donnent au développeur l'accès à l'objet et à la méthode appelés.

###### Initialisation de la librairie

```php
$armada->onInit(function($instance){
    // Your code here
});
```

###### Avant le traitement de la requête

```php
$armada->onBefore(function($instance, $method, &$bEndRequest){
    // Your code here
});
```

###### Après le traitement de la requête

```php
$armada->onAfter(function($instance, $method){
    // Your code here
});
```

###### En cas de requête invalide

```php
$armada->onInvalid(function($response, $message){
    // Your code here
});
```

###### En cas d'erreur

```php
$armada->onError(function($response, $exception){
    // Your code here
});
```

Les paramètres `$instance` et `$method` sont respectivement l'instance de la classe Jaxon et le nom de la méthode invoquées.
Le paramètre `$bEndRequest` est un booléen que l'on peut passer à `true` dans la callback pour interrompre la requête en cours.
L'objet `Response` est soit accessible dans l'objet avec `$instance->response`, soit passé en paramètre à la callback.
En cas de requête invalide, le paramètre `$message` donne la cause, et en cas d'erreur, le paramètre `$exception` est l'exception qui a été levée.
