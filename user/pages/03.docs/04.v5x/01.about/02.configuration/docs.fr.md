---
title: Configurer la librairie
menu: Configuration
template: jaxon
---

Les options de la librairie Jaxon peuvent être définis dans un fichier de configuration qui va être chargé au démarrage de l'application, avec l'appel suivant.

```php
// Configuration
jaxon()->app()->setup('/path/to/config.php');
```

Le fichier de configuration peut être aux formats `php`, `json` ou `yaml`, et comporte deux sections principales, identifiées avec les mots-clés `app` et `lib`.

La section `lib` contient la configuration de l'implémentation Ajax de la librairie, et de ses plugins.

La section `app` contient la configuration des fonctions de niveau applicatif telles que [les classes et fonctions à exporter](../../registrations/namespaces.html), [les librairies de dialogue](../../ui-features/dialogs.html), [les vues](../../ui-features/views.html), [les annotations](../../components/attributes.html), et [les packages](../../extensions/packages.html).
Les options contenues dans cette section dont documentées avec les fonctions correspondantes.

Les valeurs des options de configuration de la section `lib` sont modifiées avec les appels `jaxon()->setOption($name, $value)` ou `jaxon()->setOptions($values)`, où `$values` est un tableau.
La fonction `jaxon()->getOption($name)` permet de les lire.

De la même façon, les valeurs des options de configuration de la section `app` sont modifiées avec `jaxon()->setAppOption($name, $value)` ou `jaxon()->setAppOptions($values)`, et lues avec `jaxon()->getAppOption($name)`.

#### Fonction dépréciée

La librairie Jaxon permet aussi de charger les options de configuration de l'implémentation Ajax (le contenu de la section `lib`) depuis un fichier, avec l'appel suivant.

```php
jaxon()->config()->load($phpFilePath);
```

L'utilisation de cette fonction est maintenant déconseillée, car elle fait doublon avec la fonction `setup()` ci-dessus.

#### Les options de configuration

Ces options sont celles de la librairie Jaxon. D'autres options peuvent exister pour ses plugins.

| Nom | Type | Description |
|-----|------|-------------|
| core.version                  | string  | Le numéro de version de la librairie |
| core.language                 | string  | La langue de la librairie |
| core.encoding                 | string  | L'encodage des caractères à utiliser |
| core.decode_utf8              | boolean | Active ou non le décodage en UTF8 des paramètres des fonctions Jaxon |
| | | |
| core.prefix.function          | string  | Le préfixe à ajouter au nom des fonctions exportées en javascript |
| core.prefix.class             | string  | Le préfixe à ajouter au nom des classes exportées en javascript |
| | | |
| core.request.uri              | string  | L'URL à laquelle toutes les requêtes sont envoyées |
| core.request.mode             | string  | Le mode des requêtes. Peut être "asynchronous" or "synchronous" |
| core.request.method           | string  | La méthode des requêtes. Peut être "POST" or "GET" |
| core.request.csrf_meta        | string  | Le nom de l'entête HTML meta qui contient le token CSRF |
| | | |
| core.process.clean            | boolean | Active ou non le vidage des buffers après le traitement d'une requête |
| core.process.exit             | boolean | Indique si la fonction exit() doit être appelée après le traitement d'une requête |
| core.process.timeout          | integer |  |
| | | |
| core.error.handle             | boolean | Active ou non la gestion des erreurs |
| core.error.log_file           | string  | Le chemin du fichier de log des erreurs |
| | | |
| core.debug.on                 | boolean | Active ou non le mode debug |
| core.debug.verbose            | boolean | Active ou non le mode debug verbeux |
| core.debug.output_id          | string  | L'id de la sortie des debug javascript |
| | | |
| js.lib.uri                    | string  | Le lien vers les libraries javascript de Jaxon |
| js.lib.queue_size             | integer | Le nombre max de commandes que la librairie javascript attend dans une réponse |
| js.lib.show_cursor            | boolean | Active ou non l'affichage d'un curseur |
| js.lib.show_status            | boolean | Active ou non l'affichage du statut de la requête |
| | | |
| js.app.uri                    | string  | Le lien vers les fichiers javascript générés par Jaxon |
| js.app.dir                    | string  | Le répertoire qui contient les fichiers javascript générés par Jaxon |
| js.app.export                 | boolean | Active ou non la création d'un fichier javascript contenant le code généré par Jaxon |
| js.app.minify                 | boolean | Active ou non la minification du code généré par Jaxon |
| js.app.file                   | string  | Le nom du fichier javascript, sans son extension |
| js.app.options                | string  | Les options à ajouter à la balise javascript dans le code HTML généré |
| | | |
| core.upload.enabled           | boolean | Active ou non la fonctionnalité d'upload de fichiers |
| | | |
