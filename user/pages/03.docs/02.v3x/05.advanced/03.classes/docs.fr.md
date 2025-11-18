---
title: Les classes
menu: Les classes
template: jaxon
---

Les classes exportées avec Jaxon peuvent hériter de `Jaxon\CallableClass`, qui leur fournit des fonctions pour pour gérer les requêtes, les réponses, les vues et les sessions.

#### Retrouver une instance d'une autre classe

La méthode `cl()` retourne une instance d'un autre classe Jaxon enregistrée. Elle prend en paramètre le nom complet de la classe, avec le namespace.

Par exemple l'instance de la classe `\Namespace\Subdir\Class` sera retrouvée avec l'appel suivant.

```php
$myClass = $this->cl('Namespace\Subdir\Class');
```

Le caractère `.` peut aussi être utilisée comme séparateur.

```php
$myClass = $this->cl('Namespace.Subdir.Class');
```

Si le nom de la classe commence par le caractère `:`, la classe est recherchée dans le même namespace que l'appelant.

```php
$myClass = $this->cl(':Subdir.Class');
```

Si le nom de la classe commence par le caractère `.`, la classe est recherchée dans le même répertoire que l'appelant.

```php
$myClass = $this->cl('.Class');
```

#### L'objet `Response`

Toutes les instances des classes qui héritent de `Jaxon\CallableClass` ont accès à un même objet `Response` avec leur attribut `response`.
Cet attribut est automatiquement initialisé par la librairie, et permet de construire la réponse à une requête en appelant plusieurs méthodes de une ou plusieurs classes.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA()
    {
        $this->response->alert('ClassA::doAB() called.');
        // Appeler la méthode doB() de cette classe
        $this->doB();
        return $this->response;
    }

    public function doB()
    {
        $this->response->alert('ClassA::doB() called.');
        // Appeler la méthode doA()
        $this->doA();
        // Appeler la méthode doB() de la classe ClassB
        $this->cl('.ClassB')->doB();
        return $this->response;
    }
}
```

```php
class ClassB extends \Jaxon\CallableClass
{
    public function doB()
    {
        $this->response->alert('ClassB::doB() called.');
        return $this->response;
    }
}
```

#### La fabrique de requête

La méthode `rq()` renvoie une requête vers la classe qui l'appelle.
Elle fournit une interface fluide qui transforme un appel d'une de ses méthodes en requête vers cette méthode, qui peut alors être associée à des évènements sur des élements de la page web.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA()
    {
        // Lier le click sur le bouton avec l'id "btn-a" à un appel à la méthode doB() de cette classe
        $this->response->onClick('btn-a', $this->rq()->doB());

        // Lier le click sur le bouton avec l'id "btn-b" à un appel à la méthode doB() de la classe ClassB
        $this->response->onClick('btn-b', $this->cl('.ClassB')->rq()->doB());
        return $this->response;
    }
}
```

Le contenu de la page peut être passé en paramètre aux appels à l'aide de [la fabrique de requête](../../requests/factory) ou de [l'API jQuery PHP](../../advanced/jquery), et leurs fonctions globales `pm()` et `jq()`.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA()
    {
        // Paramètre avec la fabrique de requête
        $this->response->onClick('btn-a', $this->rq()->doB(pm()->form('form-user')));

        // Paramètre avec l'API jQuery PHP
        $this->response->onClick('btn-b', $this->cl('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

#### L'API jQuery PHP

La méthode `jq()` ajoute un appel à jQuery dans la réponse.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA()
    {
        // Lier le click sur le bouton avec l'id "btn-a" à un appel à la méthode doB() de cette classe
        $this->jq('#btn-a')->click($this->rq()->doB(rq()->form('form-user')));

        // Lier le click sur le bouton avec l'id "btn-b" à un appel à la méthode doB() de la classe ClassB
        $this->jq('#btn-b')->click($this->cl('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

L'appel `$this->jq()` est l'équivalent de `$this->response->jQuery()`.

#### La pagination

La méthode `paginate()` (ou sa version courte `pg()`) crée les liens de pagination vers une méthode d'une classe Jaxon.

```php
class ClassA extends \Jaxon\CallableClass
{
    public function doA($pageNumber)
    {
        // Insert the pagination links into the page
        $pagination = $this->rq()->doA(pm()->page())->paginate($currentPage, $itemsPerPage, $totalPages);
        $this->response->assign('pagination-links', 'innerHTML', $pagination);
        return $this->response;
    }
}
```
