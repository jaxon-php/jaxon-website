---
title: Les classes
menu: Les classes
template: jaxon
---

#### La configuration

La section `app.classes` de la configuration de Armada contient un tableau des répertoires dans lesquels se trouvent les classes à exporter.
Chaque entrée du tableau représente un répertoire, défini avec les informations suivantes:

- `directory` : le chemin complet du répertoire.
- `namespace` : le namespace associé au répertoire.
- `separator` : optionnel, le séparateur dans les noms des classes javascript, peut prendre les valeurs `.` (par défaut) ou `_`.
- `protected` : optionnel, un tableau de méthodes à ne pas exporter dans les classes javascript, par défaut vide.

Ce tableau doit toujours contenir au moins une entrée.
Le code suivant est extrait de [l'exemple d'utilisation de Armada](https://github.com/jaxon-php/jaxon-examples/blob/master/armada/config/jaxon.php).

```php
    'app' => array(
        'classes' => array(
            array(
                'directory' => dirname(__DIR__) . '/classes',
                'namespace' => '\\Jaxon\\App',
                // 'separator' => '.',
                // 'protected' => [],
            ),
        ),
    ),
```

#### La classe `Jaxon\Sentry\Classes\Base`

Les classes de l'application doivent hériter de `Jaxon\Sentry\Classes\Base`, qui leur fournit des fonctions pour accéder à d'autres classes, et pour gérer les requêtes, les réponses, les vues et les sessions.

La méthode `instance()` (ou sa version courte `cl()`) retourne une instance d'un autre classe Jaxon dans le même namespace. Elle prend en paramètre le nom de la classe, sans le namespace.

Par exemple l'instance de la classe `\Namespace\Subdir\Class` dans le namespace `Namespace` sera retrouvée avec l'appel suivant.

```php
$myClass = $this->instance('Subdir.Class');
```

Si les deux classes sont dans le même répertoire, le sous-répertoire peut être omis, et le nom de la classe est précédé par un point.

```php
$myClass = $this->instance('.Class');
```

#### L'objet `Response`

Toutes les instances de classes enregistrées dans une application Armada ont accès à un même objet `Response` avec leur attribut `response`.
Cet objet est automatiquement initialisé par la librairie, et permet de construire la réponse à une requête en appelant plusieurs méthodes ou plusieurs classes.

```php
class ClassA extends \Jaxon\Sentry\Classes\Base
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
        // Appeler la méthode doB() de la classe ClassB
        $this->instance('.ClassB')->doB();
        return $this->response;
    }
}
```

```php
class ClassB extends \Jaxon\Sentry\Classes\Base
{
    public function doB()
    {
        $this->response->alert('ClassB::doB() called.');
        return $this->response;
    }
}
```

#### La fabrique de requête

La méthode `request()` (ou sa version courte `rq()`) renvoie une requête vers la classe qui l'appelle.
Elle fournit une interface fluide qui transforme chaque appel reçu en requête vers la même méthode dans la classe qui l'appelle.

```php
class ClassA extends \Jaxon\Sentry\Classes\Base
{
    public function doA()
    {
        // Lier le click sur le bouton avec l'id "btn-a" à un appel à la méthode doB() de cette classe
        $this->response->onClick('btn-a', $this->rq()->doB());

        // Lier le click sur le bouton avec l'id "btn-b" à un appel à la méthode doB() de la classe ClassB
        $this->response->onClick('btn-b', $this->ct('.ClassB')->rq()->doB());
        return $this->response;
    }
}
```

Le contenu de la page peut être passé en paramètre aux appels à l'aide de [la fabrique de requête](/docs/requests/factory) ou de [l'API jQuery PHP](/docs/advanced/jquery), et leurs fonctions globales `rq()` et `jq()`.

```php
class ClassA extends \Jaxon\Sentry\Classes\Base
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
class ClassA extends \Jaxon\Sentry\Classes\Base
{
    public function doA()
    {
        // Lier le click sur le bouton avec l'id "btn-a" à un appel à la méthode doB() de cette classe
        $this->jQuery('#btn-a')->click($this->rq()->doB(rq()->form('form-user')));

        // Lier le click sur le bouton avec l'id "btn-b" à un appel à la méthode doB() de la classe ClassB
        $this->jQuery('#btn-b')->click($this->ct('.ClassB')->rq()->doB(jq('#username')->val()));
        return $this->response;
    }
}
```

L'appel `$this->jQuery()` est l'équivalent de `$this->response->jQuery()`.

#### La pagination

La méthode `paginator()` (ou sa version courte `pg()`) crée les liens de pagination vers une méthode d'une classe Jaxon.

```php
class ClassA extends \Jaxon\Sentry\Classes\Base
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
