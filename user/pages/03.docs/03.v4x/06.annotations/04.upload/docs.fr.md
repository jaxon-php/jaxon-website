---
title: L'upload de fichiers
menu: L'upload de fichiers
template: jaxon
---

L'annotation `@upload` ajoute le [transfert de fichiers](../../05.features/06.upload/) à une requête ajax.
Elle prend l'id du champ HTML en paramètre obligatoire.
Elle s'applique uniquement aux méthodes.

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

La syntaxe PHP-DOC peut également être utilisée.

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
