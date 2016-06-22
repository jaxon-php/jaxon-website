---
title: Configuration
menu: Configuration
template: docs
---

Le comportement de la librairie Jaxon peut être modifié à l'aide d'un ensemble d'options de configuration.

La fonction `$jaxon->setOption($name, $value)` permet de fixer la valeur d'une option de configuration, tandis que la fonction `$jaxon->setOption($name)` permet de lire la valeur d'une option.

**Les fichiers de configuration**

Il est également possible de lire la configuration de la librairie dans un fichier, qui peut être au format JSON, YAML ou PHP.
```php
\Jaxon\Config\Yaml::read($yamlFilePath);    // Lire la configuration dans un fichier YAML.
\Jaxon\Config\Json::read($jsonFilePath);    // Lire la configuration dans un fichier JSON.
\Jaxon\Config\Php::read($phpFilePath);      // Lire la configuration dans un fichier PHP. Le fichier contient du code qui retourne un tableau.
```
Si le fichier contient d'autres données que la configuration de la librairie Jaxon, la fonction `read()` peut prendre un second paramètre qui permet de lire la configuration uniquement dans une section du fichier.

**La liste des options de configuration**

| Nom | Type | Description |
|-----|------|-------------|
| core.version                  | string  | Le numéro de version de la librairie |
| core.language                 | string  | La langue de la librairie, qui est aussi celle de l'application qui l'utilise |
| core.encoding                 | string  | L'encodage des caractères à utiliser |
| core.decode_utf8              | boolean | Active ou non le décodage en UTF8 des paramètres des fonctions Jaxon |
| | | |
| core.prefix.function          | string  | Le préfixe à ajouter au nom des fonctions exportées en javascript |
| core.prefix.class             | string  | Le préfixe à ajouter au nom des classes exportées en javascript |
| core.prefix.event             | string  | Le préfixe à ajouter au nom des évènements exportés en javascript |
| | | |
| core.request.uri              | string  | L'URL à laquelle toutes les requêtes sont envoyées |
| core.request.mode             | string  | Le mode des requêtes. Peut être "asynchronous" or "synchronous" |
| core.request.method           | string  | La méthode des requêtes. Peut être "POST" or "GET" |
| | | |
| core.process.clean_buffer     | boolean | Active ou non le vidage des buffers après le traitement d'une requête |
| core.process.exit_after       | boolean | Indique si la fonction exit() doit être appelée après le traitement d'une requête |
| core.process.timeout          | integer |  |
| | | |
| core.error.handle             | boolean | Active ou non la gestion des erreurs |
| core.error.log_file           | string  | Le chemin du fichier de log des erreurs |
| | | |
| core.debug.on                 | boolean | Active ou non le mode debug |
| core.debug.verbose            | boolean | Active ou non le mode debug verbeux |
| | | |
| core.template.cache           | string  | Le chemin du répertoire de cache des templates |
| | | |
| js.lib.uri                    | string  | Le lien vers les libraries javascript de Jaxon |
| js.lib.queue_size             | integer | Le nombre max de commandes que la librairie javascript attend dans une réponse |
| js.lib.show_cursor            | boolean | Active ou non l'affichage d'un curseur |
| js.lib.show_status            | boolean | Active ou non l'affichage du statut de la requête |
| js.lib.load_timeout           | integer | Le timeout de chargement des librairies javascript |
| js.lib.output_id              | string  | L'id de la sortie des debug javascript |
| | | |
| js.app.uri                    | string  | Le lien vers les fichiers javascript générés par Jaxon |
| js.app.dir                    | string  | Le répertoire qui contient les fichiers javascript générés par Jaxon |
| js.app.export                 | boolean | Active ou non la création d'un fichier javascript contenant le code généré par Jaxon |
| js.app.minify                 | boolean | Active ou non la minification du code généré par Jaxon |
| js.app.options                | string  | Les options à ajouter à la balise javascript dans le code HTML généré |
| | | |
