---
title: Les composants fonctionnels
menu: Composants fonctionnels
template: jaxon
---

Les composants fonctionnels étaient appelées les [classes Callable](../../../v4x/features/classes.html) dans les versions précédentes de Jaxon.
Ce sont des classes dont les fonctions publiques sont exportées en Javascript, et peuvent donc être appelées depuis un navigateur.

Les composants fonctionnels héritent de la classe `Jaxon\App\FuncComponent`, qui leur fournit un ensemble de fonctions utilitaires.

Les fonctions fournies incluent [les vues](../../features/views.html), [les sessions](../../features/sessions.html), [l'upload de fichier](../../features/upload.html), [les logs](../../features/logging.html), le partage de données ([databags](../databags.html) et [stashes](../stashes.html)), en plus de celles décrites ci-dessous.

#### Retrouver une instance d'une autre classe

La méthode `cl()` retourne une instance d'un autre composant. Elle prend en paramètre le nom complet de la classe, avec le namespace.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        // Appeler la méthode doB() de la classe ComponentB
        $this->cl(ComponentB::class)->doB();
    }
}
```

#### L'objet `Response`

Toutes les composants ont accès à un même objet `Response` avec leur attribut `response`, qui est automatiquement initialisé par la librairie.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        $this->response->alert('ComponentA::doAB() called.');
        // Appeler la méthode doB() de cette classe
        $this->doB();
    }

    public function doB()
    {
        $this->response->alert('ComponentA::doB() called.');
        // Appeler la méthode doA()
        $this->doA();
        // Appeler la méthode doB() de la classe ComponentB
        $this->cl(ComponentB::class)->doB();
    }
}
```

```php
class ComponentB extends \Jaxon\App\FuncComponent
{
    public function doB()
    {
        $this->response->alert('ComponentB::doB() called.');
    }
}
```

#### Les fenêtres et alertes

The `Jaxon\App\Dialog\DialogTrait` trait provides the `alert()` et `dialog()` methods, which display [dialogs and messages](../../features/dialogs.html) in the page.

```php
use Jaxon\App\Dialog\DialogTrait;

class ComponentA extends \Jaxon\App\FuncComponent
{
    use DialogTrait;

    public function doA()
    {
        $this->alert()->title('Information')->info('This is an information');
    }

    public function doB()
    {
        $title = 'Modal Dialog';
        $content = '<div>This is a modal dialog</div>';
        $buttons = [
            ['title' => 'Close', 'class' => 'btn btn-danger', 'click' => 'close'],
        ];
        $this->dialog()->show($title, $content, $buttons);
    }
}
```

#### La fabrique de requête

La méthode `rq()` renvoie une requête vers le composant qui l'appelle.
Elle fournit une interface fluide qui transforme un appel d'une de ses méthodes en requête vers cette méthode, qui peut alors être associée à des évènements sur des élements de la page web.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        // Lier le click sur le bouton avec l'id "btn-a" à un appel ajax à la méthode doB() de cette classe
        $this->response->jq('#btn-a')->on('click', $this->rq()->doB());

        // Lier le click sur le bouton avec l'id "btn-b" à un appel ajax à la méthode doB() de la classe ComponentB
        $this->response->jq('#btn-b')->on('click', $this->rq(ComponentB::class)->doB());
    }
}
```

La [fabrique de requête](../../call-factory/functions.html) sera souvent utilisée dans les templates pour définir les [gestionnaires d'évènements](../../call-factory/templates.html).

#### La pagination

La méthode `paginator()` crée les liens de pagination avec les appels vers une méthode d'un composant.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    private function showPageContent($pageNumber)
    {
        // Build and display the paginated content.
        $this->response->assign('div2', 'innerHTML', "Showing page number $page");
    }

    public function showPage($pageNumber)
    {
        $itemsPerPage = 10;
        $totalItems = 150;
        $this->paginator($pageNumber, $itemsPerPage, $totalItems)
            ->page(function(int $page) {
                $this->showPageContent($page);
            })
            // Render the pagination links in the node with id "pagination".
            ->render($this->rq()->showPage(), 'pagination');
    }
}
```
