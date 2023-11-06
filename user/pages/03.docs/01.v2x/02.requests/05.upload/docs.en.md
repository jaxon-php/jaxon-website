---
title: Uploading files with Ajax
menu: File upload
template: jaxon
published: true
---

Starting from version 2.1.0 of the PHP library and version 2.0.0 for the javascript library, Jaxon implements file upload with Ajax.
A call to a class or a function can also transfert one or many files from the browser to the application, and save them into a configured directory.

The Jaxon upload function uses the javascript `FormData` object to encapsulate the uploaded files, as well as the other parameters of the Jaxon call, into an HTTP Ajax request.
For the browsers that do not have the `FormData` class available, files are uploaded using an HTTP POST request in an iframe.

#### How it works

In order to be able to upload files with Jaxon, an `input` field must first be defined in the HTML code, and have an attribute `type` of value `file`, and the `id` and `name` attributes defined.

```html
<form>
    <input type="file" id="upload_example" name="example_file" />
</form>
```

Multiple files upload is supported.

```html
<form>
    <input type="file" id="upload_example" name="example_files[]" multiple="multiple" />
</form>
```

Then, the id of the `input` field must be passed as parameter when registering the class which implements the method that processes the uploaded files.

```php
$jaxon->register(Jaxon::CALLABLE_OBJECT, new Upload(), [
    'saveFile' => array('upload' => "'upload_example'")
]);
```

If the class is registered with a directory or a namespace, then the parameter is defined as follow.

```php
$jaxon->registerClasses([
    Upload::class => [
        'saveFile' => array('upload' => "'upload_example'")
    ]
]);
```

Finally, the uploaded files are available in the Jaxon class method.

```php
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

The `Jaxon::getUploadedFiles()` method return the uploaded files in the form of an array of objects of type [`Jaxon\Request\Support\UploadedFile`](https://github.com/jaxon-php/jaxon-core/blob/master/src/Request/Support/UploadedFile.php).

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

Options can also be defined that apply only to a specific file. In this case, the `default` string in the option name is replaced by the id of the `input` file of the uploaded file, prepended with `files.`.

In the previous example, the `upload.files.upload_example.dir` option defines a different directory.

#### Upload with iframe

When the `FormData` class is not available in the browser, the files are uploaded using a simple HTTP POST request in an iframe in a first request, and the Jaxon function is called in a second request.

The HTTP request which transfers the file is sent to the same URI defined for Jaxon request.
The Jaxon request processing function must then be modified to take them into account.

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

Between the two requests, Jaxon saves data into a temporary file located in the directory defined by the `upload.default.dir` config option, which must therefore be writable.
