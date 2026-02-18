---
title: Les trois types de composants
menu: Types de composants
template: jaxon
---

Un composant dans la librairie Jaxon est une classe qui peut traiter des requêtes Ajax reçues par l'application et renvoyer une réponse, ou afficher du contenu HTML dans une partie de la page.

Un composant sera très souvent (mais pas toujours) [exporté de PHP vers Javascript](../../registrations/namespaces.html).
Un objet Javascript est alors créé et inséré dans la page, et un appel à une fonction de cet objet dans le navigateur exécute automatiquement la même fonction dans le composant PHP sur le serveur.

Trois types de composants peuvent être définis dans une application Jaxon.
- Les composants fonctionnels, qui fournissent uniquement des fonctions de traitement des requêtes Ajax,
- Les composants d'UI, qui peuvent en plus être attachés à un noeud du DOM et afficher son contenu,
- Les composants de pagination, qui affichent du contenu paginé et les liens de pagination.

Les différents types de composants sont décrits plus en détail dans les sections suivantes, et leurs fonctions sont présentées [dans cette page](../../features.html).

### Les composants fonctionnels

Les composants fonctionnels étaient appelées les [Callable classes](../../../v4x/features/classes.html) dans les versions précédentes de Jaxon.

Lorqu'un composant fonctionnel est exporté en javascript, ses fonctions publiques peuvent être appelées depuis un navigateur, dans une requête Ajax.
Plusieurs autres composants peuvent ensuite être appelés les uns après les autres, pour traiter la requête Ajax.
Chacun d'eux peut alors exécuter des fonctions et [ajouter des actions dans une réponse](../../features/responses.html), définissant ainsi les opérations à effectuer dans la page en réponse à la requête.

Un composant fonctionnel hérite de la classe `Jaxon\App\FuncComponent`, qui lui fournit un [ensemble de fonctions](../../features.html).

### Les composants d'UI

Les composants d'UI sont une nouveauté de la version 5 de Jaxon.

Ils ont les mêmes fonctions que les composants fonctionnels, mais en plus ils peuvent être attachés à un noeud du DOM.
Ils vont alors servir à gérer le contenu de ce noeud.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
</div>
```

Un composant peut également être attaché à un noeud dynamiquement.

```php
$this->response()->bind('element-id', rq(UiComponent::class));
```

Les composants d'UI héritent de la classe `Jaxon\App\NodeComponent`.
Ils peuvent implémenter une fonction `public function html(): string|Stringable` qui renvoie le contenu du noeud attaché.

```php
class UiComponent extends \Jaxon\App\NodeComponent
{
    public function html(): string
    {
        return '<div>UI component content</div>';
    }
}
```

> Note: la méthode `html()` d'un composant d'UI n'est pas exportée en Javascript.

#### Afficher un composant d'UI

Le composant d'UI hérite d'une fonction `render()`, qui lorsq'elle est appelée dans une méthode du même composant ou d'un autre composant, va mettre à jour le contenu du noeud attaché, avec le code HTML renvoyé par sa fonction `html()`.

```php
class UiComponent extends \Jaxon\App\NodeComponent
{
    public function html(): string
    {
        return '<div>UI component content</div>';
    }

    public function doA()
    {
        // Appliquer des traitements, puis afficher le composant
        // ...
        $this->render();
    }
}
```

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doB()
    {
        // Appliquer des traitements, puis afficher le composant
        // ...
        $this->cl(UiComponent::class)->render();
    }
}
```

> Note: la méthode `render()` d'un composant d'UI peut être exportée en Javascript ([voir l'option `export`](../../registrations/options.html)), et peut donc être appelée depuis la navigateur ou liée à des évènements de l'UI.

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        $this->response()->jq('#btn-refresh')
            ->on('click', $this->rq(UiComponent::class)->render());
    }
}
```

ou bien dans un template.

```php
<button type="button" class="btn btn-primary" <?php echo attr()
    ->click(rq(UiComponent::class)->render()) ?>>Clear</button>
```

Le trait `Jaxon\App\ViewRenderer` ajoute au composant d'UI la méthode `protected function renderView(string $sViewName, array $aViewData = []): void`, qui affiche directement un template sans appeler la méthode `html()`.
La méthode `protected function setViewPrefix(string $sViewPrefix)` dans ce trait définit un préfixe à appliquer aux templates affichés avec la méthode `renderView()`.

#### Les autres fonctions des composants d'UI

La fonction `public function clear(): void` supprime le contenu du noeud attaché de la page.

La fonction `public function visible(bool $bVisible): void`, selon le paramètre booléen qu'elle reçoit, affiche ou cache le noeud attaché, sans modifier son contenu.

Les fonctions `protected function before(): void` et `protected function after(): void` sont appelées respectivement avant et après l'affichage du composant dans la fonction `render()`.
Elles servent généralement à préparer ou à compléter l'affichage du composant, soit en allant chercher des données, soit en affichant d'autres composants.

> Note: les méthodes `clear()` et  `visible()` d'un composant d'UI peuvent être exportées en Javascript ([voir l'option `export`](../../registrations/options.html)), et peuvent donc être appelées depuis la navigateur ou liées à des évènements de l'UI.

### Les composants de pagination

Les composants de pagination affichent les [contenus paginés et les liens de pagination correspondants](../../ui-features/pagination.html).

Le composant de pagination est d'abord un composant d'UI, ce qui signifie qu'il est attaché à un noeud du DOM et gère son contenu.
Il possède en plus un autre composant d'UI, créé automatiquement par la librairie, pour l'affichage des liens de pagination.
La méthode `attr()->pagination()` affiche ce composant dans les templates.

```php
<div class="row">
    <!-- Contenu du composant de pagination -->
    <div class="col-md-12" <?php echo attr()->bind(rq(PageComponent::class)) ?>>
    </div>
    <!-- Contenu du composant des liens de pagination -->
    <div class="col-md-12" <?php echo attr()->pagination(rq(PageComponent::class)) ?>>
    </div>
</div>
```

> Note: le contenu du composant des liens de pagination est affiché uniquement si le nombre de pages est supérieur à 1.

#### Les informations de pagination

Les composants de pagination héritent de la classe `Jaxon\App\PageComponent`, et doivent implémenter des fonctions qui donnent les informations de pagination.
- La fonction `protected function limit(): int` renvoie le nombre maximal d'éléments dans une page,
- La fonction `protected function count(): int` renvoie le nombre total d'éléments à paginer.

Comme dans les composants d'UI, la fonction `public function html(): string|Stringable` renvoie le code HTML à afficher dans la page.
La méthode `currentPage()` fournie par la classe `Jaxon\App\PageComponent` renvoie le numéro de la page courante.

```php
    public function html(): string
    {
        return '<div>Contenu de la page numéro ' . $this->currentPage() . '</div>';
    }
```

Enfin, un composant de pagination doit avoir une méthode publique à paginer.
Elle doit accepter le numéro de page, un entier, parmi ses paramètres.

```php
use function Jaxon\page;

    public function showPage(int $pageNumber)
    {
        // Afficher le contenu paginé et mettre à jour les liens de pagination.
        $this->paginate($this->rq()->showPage(page()), $pageNumber);
    }
```

Dans les versions de Jaxon antérieures à `5.4.0`, le code est différent.
La fonction `paginate()` en fait implémente les mêmes trois appels.

```php
use function Jaxon\je;

    public function showPage(int $pageNumber)
    {
        // Récupérer le paginateur. Ceci met à jour également la valeur finale du numéro de page.
        $paginator = $this->paginator($pageNumber);
        // Afficher le contenu paginé.
        $this->render();
        // Afficher les liens de pagination.
        $paginator->render($this->rq()->showPage(je()->rd()->page()));
    }
```

La fonction paginée utilise donc deux paramètres: le numéro de page, qui provient généralement de l'appel Ajax à la fonction, et une [call factory](../../ui-features/call-factories.html) qui renvoie un appel Ajax à elle-même.

Voici au final le code minimal nécessaire dans un composant de pagination.

```php
class PageComponent extends \Jaxon\App\PageComponent
{
    protected function limit(): int
    {
        return 10;
    }

    protected function count(): int
    {
        return 45;
    }

    public function html():  string
    {
        return '<div>Contenu de la page numéro ' . $this->currentPage() . '</div>';
    }

    public function showPage(int $pageNumber)
    {
        // Afficher le contenu paginé et mettre à jour les liens de pagination.
        $this->paginate($this->rq()->showPage(page()), $pageNumber);
    }
}
```
