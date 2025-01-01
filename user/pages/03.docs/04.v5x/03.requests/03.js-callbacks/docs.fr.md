---
title: Callbacks Javascript
menu: Callbacks Js
template: jaxon
published: true
---

Jaxon permet également définir des callbacks javascript qui vont être appelées à différentes étapes de l'exécution de la requête dans le navigateur.

#### L'objet callback

Une callback javascript est un objet qui contient des fonctions avec des noms prédéfinis, selon l'étape où elles seront appelées.

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

Après sa définition, la callback peut être associée à une ou plusieurs requêtes Jaxon.

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

Les callbacks javascript peuvent également être définies dans le [fichier de configuration](../../features/bootstrap/) ou à l'aide d'annotations.

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

La syntaxe PHP-DOC peut également être utilisée.

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

Voici le code javascript généré.

```js
Ns.App.JaxonExample = {};
Ns.App.JaxonExample.action = function() {
    return jaxon.request(
        { jxncls: 'Ns.App.JaxonExample', jxnmthd: 'action' },
        { parameters: arguments, callback: [app.callback.example,app.callback.action] }
    );
};
```

#### Les fonctions de la callback

Les fonctions d'un objet callback sont appelées lorsqu'une requête Ajax est émise vers l'une des classes auxquelles elle a été associée.

###### La callback `onInitialize`

Appelée avant que l'objet `request` soit initialisé.
Définie dans la versio 4.0 de la librairie.

###### La callback `onProcessParams`

Appelée avant le traitement des paramètres de la requête.
Définie dans la versio 4.0 de la librairie.

###### La callback `onPrepare`

Appelée lorsque la requête est prête à être envoyée.

###### La callback `onRequest`

Appelée juste avant que la requête soit effectivement envoyée.

###### La callback `onResponseDelay`

Appelée si le délai de réponse défini dans la config expire.

###### La callback `onExpiration`

Appelée si le délai d'expiration' défini dans la config expire.

###### La callback `beforeResponseProcessing`

Appelée lorsqu'une réponse est reçue, et avant qu'elle soit traitée.

###### La callback `onSuccess`

Appelée lorsque le code de statut de la réponse HTTP indique un succès.

###### La callback `onRedirect`

Appelée lorsque le code de statut de la réponse HTTP indique une redirection.

###### La callback `onFailure`

Appelée lorsque le code de statut de la réponse HTTP indique un échec.

###### La callback `onComplete`

Appelée lorsque le traitement de la réponse est terminé, .
