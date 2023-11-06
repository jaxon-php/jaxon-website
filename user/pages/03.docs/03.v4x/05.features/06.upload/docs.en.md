---
title: Uploading files with Ajax
menu: File upload
template: jaxon
published: true
---

A call to a class or a function can also transfer one or many files from the browser to the application, and save them into a configured directory.

The Jaxon upload function uses the javascript `FormData` object to encapsulate the uploaded files, as well as the other parameters of the Jaxon call, into an HTTP Ajax request.
For the browsers that do not have the `FormData` class available, files are uploaded using an HTTP POST request in an iframe.

#### Installation

Starting from version 4, the upload feature is provided in a [separate package](https://github.com/jaxon-php/jaxon-upload), which must then be installed.

The feature is also disabled by default, and must be enabled in the configuration.

```php
$jaxon->setOption('core.upload.enabled', true);
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
    <input type="file" id="html_file_input_id" name="example_files[]" multiple="multiple" />
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

This configuration can also be done using an annotation, directly in the class.

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

The call to `jaxon()->upload()->files()` returns an array where the key is the `name` attribute of the `input` field, and the value is an array of objects of class [`Jaxon\Request\Upload\FileInterface`](https://github.com/jaxon-php/jaxon-core/blob/master/src/Request/Upload/FileInterface.php), each representing an uploaded file.

#### Configuration

The configuration options of the upload feature define the directory where the uploaded files are saved, and the conditions they must match in order to be accepted.
The matching conditions are related to their type, extension and size.

The options that apply to all uploaded files are defined in the `upload.default` section.

- `upload.default.dir`: the directory where the files are saved.
- `upload.default.types`: an array of accepted mime types.
- `upload.default.extensions`: an array of accepted extensions.
- `upload.default.max-size`: the accepted maximum size.
- `upload.default.min-size`: the accepted minimum size.

The directory defined by `upload.default.dir` option must exist and be writable.
The other options are not checked if they are undefined.

Options can also be defined that apply only to a specific file. In this case, the `default` string in the option name is replaced by the `name` attribute of the `input` field of the uploaded file, prepended with `files.`.

In the previous example, the `upload.files.example_files.dir` option defines a different directory.

#### Upload with iframe

When the `FormData` class is not available in the browser, the files are uploaded using a simple HTTP POST request in an iframe in a first request, and the Jaxon function is called in a second request.

The HTTP request which transfers the file is sent to the same URI defined for Jaxon request, and processed by the same function.
No change is required in the application.

Between the two requests, Jaxon saves data into a temporary file located in the directory defined by the `upload.default.dir` config option, which must therefore be writable.

#### Saving files

Starting from version 4, the uploaded files can be saved not only on the local disk, which is the default option, but also on various other storage systems, thanks to the [Flysystem package](https://flysystem.thephpleague.com).

The uploaded files can be saved on the following file storage systems.
- AWS S3
- Async AWS S3
- Google Cloud
- Microsoft Azure
- FTP
- SFTP V2
- SFTP V3

For each of these systems, a specific adapter package must be installed, and the connection parameters must be specified in the Jaxon configuration.

See the [jaxon-upload](https://github.com/jaxon-php/jaxon-upload) package documentation and the **Official adapters** section of the [Flysystem documentation](https://flysystem.thephpleague.com/docs/) for more information.
