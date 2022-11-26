---
title: L'upload de fichiers
menu: L'upload de fichiers
template: jaxon
---

#### L'upload de fichiers

L'annotation `@upload` permet de télécharger des fichiers dans une méthode d'une classe Jaxon.

Elle ne peut être définie que sur les méthodes, et elle ne peut pas être repétée.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    // L'appel à cette méthode télécharge les fichiers dans le champ HTML input avec l'id first_field_id.
    /**
     * @upload('field' => 'first_field_id')
     */
    public function doSomething()
    {
        // Récupérer les fichiers téléchargés.
        $uploadedFiles = $this->files();

        return $this->response;
    }

    /**
     * @upload second_field_id
     */
    public function doSomethingElse()
    {
        // Récupérer les fichiers téléchargés.
        $uploadedFiles = $this->files();

        return $this->response;
    }
}
```
