---
title: File upload
menu: File upload
template: jaxon
---

The `@upload` annotation adds [file upload](../../05.features/06.upload/) to an ajax request.
It takes the id of the HTML field as a mandatory option.
It applies only to methods.

```php
class JaxonExample
{
    /**
     * @upload('field' => 'div-user-file')
     */
    public function saveFile()
    {
        // Get the uploaded files.
        $files = $this->upload()->files();
    }
}
```

The PHP-DOC syntax can also be used.

```php
class JaxonExample
{
    /**
     * @upload div-user-file
     */
    public function saveFile()
    {
        // Get the uploaded files.
        $files = $this->upload()->files();
    }
}
```
