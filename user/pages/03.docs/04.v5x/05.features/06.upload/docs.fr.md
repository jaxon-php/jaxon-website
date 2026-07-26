---
title: Transférer des fichers (Upload) en Ajax
menu: Le transfert de fichiers
template: jaxon
---

Une requête HTTP Ajax à une fonction ou une classe Jaxon peut transférer un ou plusieurs fichiers du navigateur vers l'application, et les enregistrer dans un répertoire défini.

La fonction d'upload de Jaxon utilise l'objet `FormData` de javascript pour transporter le fichier et les autres paramètres de la fonction appelée dans la requête.

#### Installation

La fonction d'upload est fournie dans un [package séparé](https://github.com/jaxon-php/jaxon-upload), qui doit donc être installé.

La fonction est également désactivée par défaut, et doit donc être activée dans la configuration.

```php
$jaxon->setAppOption('upload.enabled', true);
```

```php
    'app' => [
        'upload' => [
            'enabled' => true,
        ],
    ],
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
    <input type="file" id="html_file_input_id" name="html_file_input_id[]" multiple="multiple" />
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

Cette configuration peut aussi se faire à l'aide d'un attribut ou d'une annotation, directement dans la classe.

```php
use Jaxon\Attributes\Attribute\Upload;

class Upload
{
    #[Upload('html_file_input_id')]
    public function saveFile()
    {
    }
}
```

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
use Jaxon\Attributes\Attribute\Upload;

class Upload
{
    #[Upload('html_file_input_id')]
    public function saveFile()
    {
        $response = jaxon()->newResponse();

        // Get uploaded files
        $aUploadedFiles = jaxon()->upload()->files();
    }
}
```

```php
use Jaxon\App\FuncComponent;
use Jaxon\Attributes\Attribute\Upload;

class Upload extends FuncComponent
{
    #[Upload('html_file_input_id')]
    public function saveFile()
    {
        // Get uploaded files
        $aUploadedFiles = $this->files();
    }
}
```

L'appel à `$this->files()` ou `jaxon()->upload()->files()` renvoie une table où la clé est l'attribut `name` du champ `input`, et la valeur est un tableau d'objets de la classe [`Jaxon\Request\Upload\FileInterface`](https://github.com/jaxon-php/jaxon-core/blob/master/src/Request/Upload/FileInterface.php), chacun représentant un fichier transféré.

#### Configuration

Les paramètres de configuration de la fonction d'upload définissent le répertoire où les fichiers transferés sont enregistrés, et les conditions qu'ils doivent respecter pour etre acceptés.
Les conditions sont définies en fonction de leur type, leur extension et leur taille.

Les paramètres qui s'appliquent à tous les fichiers sont définis dans la section `upload.default`.

```php
    'app' => [
        'upload' => [
            'enabled' => true,
            'default' => [
                // Les options par défaut.
            ],
        ],
    ],
```

- `upload.default.dir` : le répertoire où les fichiers seront enregistrés.
- `upload.default.types` : un tableau de types mime acceptés.
- `upload.default.extensions` : un tableau d'extensions de fichiers acceptées.
- `upload.default.max-size` : la taille maximale acceptée.
- `upload.default.min-size` : la taille minimale acceptée.

Le répertoire défini par le paramètre `upload.default.dir` doit exister et être et accessible en écriture.
Les autres paramètres ne seront pas vérifiés s'ils ne sont pas définis.

Les paramètres qui s'appliquent uniquement à des fichiers spécifiques sont définies dans la section `files`, avec l'`id` du champ `input` du fichier transferé comme identifiant.

```php
    'app' => [
        'upload' => [
            'enabled' => true,
            'files' => [
                'html_file_input_id' => [
                    // Les options de "html_file_input_id".
                ],
            ],
        ],
    ],
```

#### Enregistrer les fichiers transférés

Dans cette version 4, les fichiers transférés peuvent être enregistrés sur le disque local, l'option par défaut, mais également sur divers autres types de stockage, grâce aux packages [jaxon-storage](https://github.com/jaxon-php/jaxon-storage) et [Flysystem](https://flysystem.thephpleague.com).

Par défaut, les fichiers transférés sont enregistrés sur le disque local, dans les répertoires indiqués dans la configuration.

Cependant, il est également possible de les enregistrer sur tout type de stockage supporté par la librairie [Flysystem](https://flysystem.thephpleague.com).
Pour chacun de ces types de stockage, un package spécifique doit être installé.
Voir la section **Official adapters** de la [documentation de Flysystem](https://flysystem.thephpleague.com/docs/), pour plus d'informations.

Le package [jaxon-storage](https://github.com/jaxon-php/jaxon-storage) fournit une fonction pour enregistrer un adaptateur pour un type de stockage.
Par exemple, le package `league/flysystem-ftp` fournit le support du stockage sur `FTP`.

```php
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use function Jaxon\Storage\storage;

storage()->register('ftp', function(string $sRootDir, array $aOptions) {
    $aOptions['root'] = $sRootDir;
    $xOptions = FtpConnectionOptions::fromArray($aOptions);
    return new FtpAdapter($xOptions);
});
```

Ce stockage peut ensuite être utilisé pour enregistrer les fichiers transférés.

```php
    'app' => [
        'storage' => [
            'adapters' => [
                'ftp' => [], // Ces options sont passées à l'adaptateur.
            ]
            'stores' => [
                'ftp_store' => [
                    'adapter' => 'ftp',
                    'dir' => '/path/to/uploads/storage',
                    // 'options' => [], // Optional
                ],
            ],
        ],
        'upload' => [
            'enabled' => true,
            'files' => [
                'html_file_input_id' => [
                    'storage' => 'ftp_store',
                    // Les options de "html_file_input_id".
                ],
            ],
        ],
    ],
```
