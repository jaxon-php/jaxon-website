---
title: Transférer des fichers (Upload) en Ajax
menu: Transfert de fichiers
template: jaxon
published: true
---

Un appel d'une fonction ou d'une classe peut transférer un ou plusieurs fichiers du navigateur vers l'application, et les enregistrer dans un répertoire défini.

La fonction d'upload de Jaxon utilise l'objet `FormData` de javascript pour transporter le fichier et les autres paramètres de la fonction appelée dans une requête HTTP Ajax.
Pour les navigateurs qui ne disposent pas de l'objet `FormData`, les fichiers sont transferés avec une requête HTTP POST dans un iframe.

#### Installation

Dans cette version 4, la fonction d'upload est fournie dans un [package séparé](https://github.com/jaxon-php/jaxon-upload), qui doit donc être installé.

La fonction est également désactivée par défaut, et doit donc être activée dans la configuration.

```php
$jaxon->setOption('core.upload.enabled', true);
```

#### Fonctionnement

Pour transférer un fichier avec Jaxon, un attribut `id` unique doit être défini sur le champ HTML `input`.

```html
<form>
    <input type="file" id="html_file_input_id" name="example_file" />
</form>
```

Les uploads de fichiers multiples sont pris en charge.

```html
<form>
    <input type="file" id="html_file_input_id" name="example_files[]" multiple="multiple" />
</form>
```

Ensuite, il faut passer la valeur de cet id en paramètre à l'enregistrement de la classe ou la fonction qui va traiter le fichier transferé.

```php
$jaxon->register(Jaxon::CALLABLE_CLASS, Upload::class, [
    'functions' => [
        'saveFile' => [
            'upload' => "'html_file_input_id'"
        ]
    ]
]);
```

Et lorsqu'on enregistre un répertoire,

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', [
    'classes' => [
        Upload::class => [
            'functions' => [
                'saveFile' => [
                    'upload' => "'html_file_input_id'"
                ]
            ]
        ]
    ]
]);
```

Cette configuration peut aussi se faire à l'aide d'une annotation, directement dans la classe.

```php
class Upload
{
    /**
     * @upload html_file_input_id
     */
    public function saveFile()
    {
    }
}
```

Enfin, les fichiers transferés sont disponibles dans la fonction appelée.

```php
use function Jaxon\jaxon;

class Upload
{
    /**
     * @upload html_file_input_id
     */
    public function saveFile()
    {
        $response = jaxon()->newResponse();

        // Get uploaded files
        $aUploadedFiles = jaxon()->upload()->files();

        return $response;
    }
}
```

```php
class Upload extends JaxonCallable
{
    /**
     * @upload html_file_input_id
     */
    public function saveFile()
    {
        // Get uploaded files
        $aUploadedFiles = $this->files();

        return $this->response;
    }
}
```

L'appel à `jaxon()->upload()->files()` renvoie une table où la clé est l'attribut `name` du champ `input`, et la valeur est un tableau d'objets de la classe [`Jaxon\Request\Upload\FileInterface`](https://github.com/jaxon-php/jaxon-core/blob/master/src/Request/Upload/FileInterface.php), chacun représentant un fichier transféré.

#### Configuration

Les paramètres de configuration de la fonction d'upload définissent le répertoire où les fichiers transferés sont enregistrés, et les conditions qu'ils doivent respecter pour etre acceptés.
Les conditions sont définies en fonction de leur type, leur extension et leur taille.

Les paramètres qui s'appliquent à tous les fichiers sont définis dans la section `upload.default`.

- `upload.default.dir` : le répertoire où les fichiers seront enregistrés.
- `upload.default.types` : un tableau de types mime acceptés.
- `upload.default.extensions` : un tableau d'extensions de fichiers acceptées.
- `upload.default.max-size` : la taille maximale acceptée.
- `upload.default.min-size` : la taille minimale acceptée.

Le répertoire défini par le paramètre `upload.default.dir` doit exister et être et accessible en écriture.
Les autres paramètres ne seront pas vérifiés s'ils ne sont pas définis.

Pour définir des paramètres qui vont s'appliquer uniquement à des fichiers spécifiques, il faut remplacer la chaîne `default` par l'attribut `name` du champ `input` du fichier transferé, préfixé de `files.`.

Dans l'exemple précédent, l'option `upload.files.example_files.dir` définit un répertoire différent.

#### Transfert avec iframe

Lorsque l'objet `FormData` n'est pas disponible dans le navigateur, un iframe est créé pour transférer le fichier dans une première requête HTTP POST classique, et la fonction Jaxon est appelée dans une seconde requête.

La requête HTTP qui transfère le fichier est envoyée à l'URI définie pour les requêtes Jaxon, et traitée par la même fonction.
Aucun changement n'est donc requis dans l'application.

Entre les deux requêtes, Jaxon enregistre des données temporaires dans un fichier placé dans le répertoire défini par l'option `upload.default.dir`, qui doit donc être accessible en écriture.

#### Enregistrer les fichiers

Dans cette version 4, les fichiers transférés peuvent être enregistrés sur le disque local, l'option par défaut, mais également sur divers autres types de stockage, grâce au [package Flysystem](https://flysystem.thephpleague.com).

Les fichiers peuvent être enregistrés sur les systèmes de stockage suivants:
- AWS S3
- Async AWS S3
- Google Cloud
- Microsoft Azure
- FTP
- SFTP V2
- SFTP V3

Pour chacun de ses systèmes, un package spécifique doit être installé, et des paramètres de connexion doivent être fournis dans la configuration de Jaxon.

Voir la documentation du package  [jaxon-upload](https://github.com/jaxon-php/jaxon-upload), et la section **Official adapters** de la [documentation de Flysystem](https://flysystem.thephpleague.com/docs/), pour plus d'informations.
