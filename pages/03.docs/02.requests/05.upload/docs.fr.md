---
title: Transférer des fichers (Upload) en Ajax
menu: Transfert de fichiers
template: jaxon
published: true
---

A partir de la version 2.1.0, et de la version 2.0.0 de la librairie javascript, Jaxon implémente le transfert de fichier avec Ajax.
Un appel d'une fonction ou d'une classe peut transférer un ou plusieurs fichiers du client vers l'application, et les enregistrer dans un répertoire défini.

La fonction d'upload de Jaxon utilise l'objet `FormData` de javascript pour transporter le fichier et les autres paramètres de la fonction appelée dans une requête HTTP Ajax.
Pour les navigateurs qui ne disposent pas de l'objet `FormData`, les fichiers sont transferés avec une requête HTTP POST dans un iframe.

#### Fonctionnement

Pour uploader un fichier avec Jaxon, il faut définir dans le code HTML un champ `input` avec un attribut `type` qui a la valeur `file`, et avec des attributs `id` et `name`.

```html
<form>
    <input type="file" id="upload_example" name="example_file" />
</form>
```

Les uploads de fichiers multiples sont pris en charge.

```html
<form>
    <input type="file" id="upload_example" name="example_files[]" multiple="multiple" />
</form>
```

Ensuite, il faut passer l'id du champ `input` en paramètre à l'enregistrement de la classe ou la fonction qui va traiter le fichier transferé.

```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new Upload(), [
    'saveFile' => array('upload' => "'upload_example'")
]);
```

Si la classe est enregistrée dans un répertoire ou un namespace, le paramètre est défini ainsi.

```php
$jaxon->registerClasses([
    Upload::class => [
        'saveFile' => array('upload' => "'upload_example'")
    ]
]);
```

Enfin, les fichiers transferés sont disponibles dans la fonction appelée.

```
class Upload
{
    public function saveFile()
    {
        // Get uploaded files
        $aUploadedFiles = jaxon()->getUploadedFiles();

        return $this->response;
    }
}
```

La methode `getUploadedFiles()` renvoie les fichiers transferés dans un tableau d'objets de type [`Jaxon\Request\Support\UploadedFile`](https://github.com/jaxon-php/jaxon-core/blob/master/src/Request/Support/UploadedFile.php).

#### Configuration

Les paramètres de configuration de la fonction d'upload définissent le répertoire où les fichiers transferés sont enregistrés, et les conditions qu'ils doivent respecter pour etre acceptés.
Les conditions sont définies en fonction de leur type, leur extension et leur taille.

Les paramètres qui s'appliquent à tous les fichiers sont définis dans la section `upload.default`.

- `upload.default.dir` : le répertoire où les fichiers seront enregistrés.
- `upload.default.types` : les types mime acceptés.
- `upload.default.extensions` : Les extensions de fichiers acceptés.
- `upload.default.max-size` : la taille maximale des fichiers.
- `upload.default.min-size` : la taille minimale des fichiers.

Un paramètre non défini ne sera pas vérifié.

Pour définir des paramètres qui vont s'appliquer uniquement à des fichiers spécifiques, il faut remplacer la chaîne `default` par l'id du champ `input` du fichier transferé.
Dans l'exemple précédent, l'option `upload.upload_example.dir` définit un répertoire différent.

#### Transfert avec iframe

Lorsque l'objet `FormData` n'est pas disponible dans le navigateur, un iframe est créé pour transférer le fichier dans une première requête HTTP POST classique, et la fonction Jaxon est appelée dans une seconde requête.

La requête HTTP qui transfère le fichier est envoyée à l'URI définie pour les requêtes Jaxon.
Il faut donc modifier la fonction de traitement pour les prendre en compte.

```php
if($jaxon->canProcessRequest())
{
    // Process the request.
    $jaxon->processRequest();
}
else if($jaxon->hasUploadedFiles())
{
    // Process upload.
    $jaxon->saveUploadedFiles();
}
```

Entre les deux requêtes, Jaxon enregistre des données temporaires dans un fichier placé dans le répertoire défini par l'option `upload.default.dir`, qui doit donc être accessible en écriture.
