---
title: Uploading files with Ajax
menu: File upload
template: jaxon
---

An HTTP Ajax request to a jaxon class or a function can also transfer one or many files from the browser to the application, and save them into a configured directory.

The Jaxon upload function uses the javascript `FormData` object to encapsulate the uploaded files, as well as the other parameters of the Jaxon call, into the request.

#### Installation

The upload feature is provided in a [separate package](https://github.com/jaxon-php/jaxon-upload), which must then be installed.

The feature is also disabled by default, and must be enabled in the configuration.

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

#### How it works

In order to be able to upload files with Jaxon, a unique `id` attribute must be set on the HTML `input` field.

```html
<form>
    <input type="file" id="html_file_input_id" name="example_file" />
</form>
```

Multiple files upload is supported.

```html
<form>
    <input type="file" id="html_file_input_id" name="html_file_input_id[]" multiple="multiple" />
</form>
```

The value of this id must then be passed as parameter when registering the class of function that processes the uploaded files.

```php
$jaxon->register(Jaxon::CALLABLE_CLASS, Upload::class, [
    'functions' => [
        'saveFile' => [
            'upload' => "'html_file_input_id'"
        ]
    ]
]);
```

And when registering a directory,

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

This configuration can also be done using an attribute or an annotation, directly in the class.

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

At the end, the uploaded files are available in the Jaxon class method.

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

The call to `$this->files()` or `jaxon()->upload()->files()` returns an array where the key is the `name` attribute of the `input` field, and the value is an array of objects of class [`Jaxon\Request\Upload\FileInterface`](https://github.com/jaxon-php/jaxon-core/blob/master/src/Request/Upload/FileInterface.php), each representing an uploaded file.

#### Configuration

The configuration options of the upload feature define the directory where the uploaded files are saved, and the conditions they must match in order to be accepted.
The matching conditions are related to their type, extension and size.

The options that apply to all uploaded files are defined in the `upload.default` section.

```php
    'app' => [
        'upload' => [
            'enabled' => true,
            'default' => [
                // The default options.
            ],
        ],
    ],
```

- `upload.default.dir`: the directory where the files are saved.
- `upload.default.types`: an array of accepted mime types.
- `upload.default.extensions`: an array of accepted extensions.
- `upload.default.max-size`: the accepted maximum size.
- `upload.default.min-size`: the accepted minimum size.

The directory defined by `upload.default.dir` option must exist and be writable.
The other options are not checked if they are undefined.

The options to be applied only to a specific file are defined in the `files.` section, with the `id` of the uploaded file `input` field as identifier.

```php
    'app' => [
        'upload' => [
            'enabled' => true,
            'files' => [
                'html_file_input_id' => [
                    // The "html_file_input_id" options.
                ],
            ],
        ],
    ],
```

#### Saving the uploaded files

Starting from version 4, the uploaded files can be saved not only on the local disk, which is the default option, but also on various other storage systems, thanks to the [jaxon-storage](https://github.com/jaxon-php/jaxon-storage) and the [Flysystem](https://flysystem.thephpleague.com) packages.

By default, the uploaded files are saved on the local disk, in the directories specified in the configuration.

However, it is also possible to save them on any type of storage supported by the [Flysystem](https://flysystem.thephpleague.com) library.
For each of these types of storage, a specific adapter package must be installed.
See the **Official adapters** section of the [Flysystem documentation](https://flysystem.thephpleague.com/docs/) for more information.

The [jaxon-storage](https://github.com/jaxon-php/jaxon-storage) package provides a function to register an adapter for a storage type.
For example, the `league/flysystem-ftp` package provides support for `FTP` storage.

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

This storage can then be used to save the uploaded files.

```php
    'app' => [
        'storage' => [
            'adapters' => [
                'ftp' => [], // These options are passed to the adapter closure
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
                    // The "html_file_input_id" options.
                ],
            ],
        ],
    ],
```
