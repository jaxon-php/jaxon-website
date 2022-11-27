---
title: File upload
menu: File upload
template: jaxon
---

The `@upload` annotation implements file upload in a method of a Jaxon class.

It can be declared only on methods, and it cannot be repeated.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    // Calls to this method will upload the files in the HTML input field with id first_field_id.
    /**
     * @upload('field' => 'first_field_id')
     */
    public function doSomething()
    {
        // Get the uploaded files.
        $uploadedFiles = $this->files();

        return $this->response;
    }

    /**
     * @upload second_field_id
     */
    public function doSomethingElse()
    {
        // Get the uploaded files.
        $uploadedFiles = $this->files();

        return $this->response;
    }
}
```
