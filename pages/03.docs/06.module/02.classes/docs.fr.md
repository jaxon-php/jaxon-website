---
title: Les classes Jaxon
menu: Les classes Jaxon
template: jaxon
---

#### La configuration

La section `app.controllers` de la configuration du Module contient dans un tableau la liste des répertoires dans lesquels se trouvent les classes à enregistrer (les contrôleurs).
Chaque entrée du tableau représente un répertoire, défini avec les informations suivantes:

- `directory` : le chemin du répertoire.
- `namespace` : le namespace associé au répertoire.
- `separator` : optionnel, le séparateur dans les noms des classes javascript, peut prendre les valeurs `.` (par défaut) ou `_`.
- `protected` : optionnel, un tableau de noms de méthodes à ne pas exporter dans les classes javascript, par défaut vide.

#### La classe `Controller`

Les classes de l'application doivent hériter de `Jaxon\Module\Controller`, qui leur fournit des fonctions pour accéder à d'autres contrôleurs, gérer les réquêtes, les réponses, les sessions et les vues.

La méthode `controller()` (ou sa version courte `ct()`) retourne une instance d'un autre classe Jaxon dans le même namespace. Elle prend en paramètre le nom de la classe, sans le namespace.

Par exemple l'instance de la classe `\Namespace\Subdir\Class` dans le namespace `Namespace` sera retrouvée dans une autre classe du même namespace avec l'appel suivant.

```php
    $myClass = $this->controller('Subdir.Class');
```

Si les deux classes sont dans le même répertoire, le sous-répertoire peut être omis, et le nom de la classe est précédé par un point.

```php
    $myClass = $this->controller('.Class');
```

#### L'objet `Response`

Toutes les instances de classes enregistrées avec le Module de Jaxon ont accès à un même objet `Response` avec leur attribut `response`.
Il est automatiquement initialisé par la librairie, et permet de construire la réponse à une requête en appelant plusieurs méthodes ou plusieurs classes.

```php
class ClassA extends \Jaxon\Module\Controller
{
    public function doA()
    {
        // Local processing
        $this->response->alert('ClassA::doAB() called.');

        // Call the doA() method of this class
        $this->doB();
        return $this->response;
    }

    public function doB()
    {
        // Local processing
        $this->response->alert('ClassA::doB() called.');

        // Call the doB() method of class ClassB
        $this->controller('.ClassB')->doB();
        return $this->response;
    }
}
```

```php
class ClassB extends \Jaxon\Module\Controller
{
    public function doB()
    {
        // Local processing
        $this->response->alert('ClassB::doB() called.');
        return $this->response;
    }
}
```

#### La fabrique de requête

La méthode `request()` (ou sa version courte `rq()`) renvoie une requête vers sa classe.
Elle fournit une interface fluide qui transforme les appels vers ses méthodes en requêtes vers les mêmes méthodes dans la classe Jaxon.

```php
class ClassA extends \Jaxon\Module\Controller
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to a call to the doB() method in this class
        $this->response->onClick('btn-a', $this->rq()->doB());

        // Bind the click on the button with id "btn-b" to a call to the doB() method in class ClassB
        $this->response->onClick('btn-b', $this->ct('.ClassB')->rq()->doB());
        return $this->response;
    }
}
```

Le contenu de la page peut être passé en paramètre aux appels à l'aide de la fabrique de requête ou de l'API jQuery PHP, et leurs fonctions globales `rq()` et `jq()`.

```php
class ClassA extends \Jaxon\Module\Controller
{
    public function doA()
    {
        // Paramètre avec la fabrique de requête
        $this->response->onClick('btn-a', $this->rq()->doB(rq()->form('form-user')));

        // Paramètre avec l'API jQuery PHP
        $this->response->onClick('btn-b', $this->ct('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

#### L'API jQuery PHP

La méthode `jQuery()` (ou sa version courte `jq()`) ajoute un appel jQuery dans la réponse.

```php
class ClassA extends \Jaxon\Module\Controller
{
    public function doA()
    {
        // Bind the click on the button with id "btn-a" to a call to the doB() method
        $this->jq('#btn-a')->click($this->rq()->doB(rq()->form('form-user')));

        // Bind the click on the button with id "btn-b" to a call to the doB() method in class ClassB
        $this->jq('#btn-b')->click($this->ct('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

L'appel `$this->jQuery()` est l'équivalent de `$this->response->jQuery()`.

#### La pagination

La méthode `paginator()` (ou sa version courte `pg()`) crée les liens de pagination vers une méthode d'une classe Jaxon.

```php
class ClassA extends \Jaxon\Module\Controller
{
    public function doA($pageNumber)
    {
        // Insert the pagination links into the page
        $pagination = $this->paginator($totalPages, $itemsPerPage, $currentPage)->doA(rq()->page());
        $this->response->assign('pagination-links', 'innerHTML', $pagination);
        return $this->response;
    }
}
```
