---
title: Les fonctions des composants
menu: Fonctions des composants
template: jaxon
---

Les [classes de base des composants Jaxon](../types.html) fournissent un large ensemble de fonctions, comprenant [les vues](../../ui-features/views.html), [les sessions](../../features/sessions.html), [l'upload de fichier](../../features/upload.html), [les logs](../../features/logging.html), le partage de données (avec [databags](../databags.html) et [stash](../stash.html)).

Les autres fonctions des composants sont décrites ci-dessous.

### Appeler un autre composant

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

### L'objet `Response`

Toutes les composants ont accès à un même objet `Response` avec leur attribut `response`, qui est automatiquement initialisé par la librairie.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        $this->response()->alert('ComponentA::doAB() called.');
        // Appeler la méthode doB() de cette classe
        $this->doB();
    }

    public function doB()
    {
        $this->response()->alert('ComponentA::doB() called.');
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
        $this->response()->alert('ComponentB::doB() called.');
    }
}
```

### L'objet `NodeResponse`

La classe `Jaxon\App\NodeComponent` possède une méthode `node()` qui retourne une réponse spéciale, qui est liée au noeud attaché.

Les [fonctions de manipulation du contenu et du style](../../features/responses.html) de cet objet ne possèdent plus le paramètre `string $sTarget`, car elles vont agir uniquement sur le noeud attaché.

### La fabrique de requête

La méthode `rq()` renvoie une requête vers le composant qui l'appelle.
Elle fournit une interface fluide qui transforme un appel d'une de ses méthodes en requête vers cette méthode, et qui peut être associée à des évènements sur des élements de la page web.

```php
class ComponentA extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        // Lier le click sur le bouton avec l'id "btn-a" à un appel ajax à la méthode doB() de cette classe
        $this->response()->jq('#btn-a')->on('click', $this->rq()->doB());

        // Lier le click sur le bouton avec l'id "btn-b" à un appel ajax à la méthode doB() de la classe ComponentB
        $this->response()->jq('#btn-b')->on('click', $this->rq(ComponentB::class)->doB());
    }
}
```

La [fabrique de requête](../../ui-features/call-factories.html) sera souvent utilisée dans les templates pour définir les [gestionnaires d'évènements](../../ui-features/templates.html).

### Données du composant

Le trait `Jaxon\App\ComponentDataTrait` ajoute un tableau de données dans un composant.
Il fournit les méthodes `set(string $sKey, mixed $xValue): static`, `has(string $sKey): bool` et `get(string $sKey, mixed $xDefault = null): mixed`, pour resp. enregistrer, vérifier ou lire les données associées à une clé dans le tableau.

Ce tableau sert à partager des données entre les méthodes d'un composant, ou encore à passer des données à un composant.

```php
$this->cl(UiComponent::class)->set('value', $value)->render();
```

Il sera donc utilisé comme alternative au [stash](../stash.html), pour des données locales à un composant.

### Extension du composant

La méthode `protected function setupComponent(): void` permet à l'application de personnaliser le composant.
Elle est appelée une seule fois, juste après la création du composant.

La méthode `public function extend(string $target, Closure $extension)` permet à l'application de personnaliser certaines propriétés du composant.
Le paramètre `$target` peut prendre les valeurs `item` ou `html`, en fonction de l'attribut à personnaliser.
La closure fournie recevra en paramètre la valeur initiale de l'attribut, et doit retourner sa nouvelle valeur.

La méthode `extend()` sera bien souvent appelée dans la méthode `setupComponent()`.

Dans les composants de pagination, l'extension de l'attribut `item` sera automatiquement appliquée également au composant des liens.

### Remplacement de composants

Il peut parfois être utile de pouvoir afficher plusieurs composants d'UI dans le même élément HTML d'une page.
C'est par exemple le cas pour mettre en place un menu de navigation, où chaque item affiche un contenu différent dans une page.

Il faut alors attacher un premier composant d'UI à l'élément, et configurer les autres composants d'UI pour remplacer ce premier composant.

```php
<div class="page-content" <?= attr()->bind(rq(FirstComponent::class)) ?>>
</div>
```

```php
class SecondComponent extends \Jaxon\App\NodeComponent
{
    /**
     * @var string
     */
    protected string $overrides = FirstComponent::class;
}
```

```php
class ThirdComponent extends \Jaxon\App\NodeComponent
{
    /**
     * @var string
     */
    protected string $overrides = FirstComponent::class;
}
```

> Note: La relation `overrides` ne peut pas être chaînée : un composant ne peut pas remplacer un composant qui en remplace déjà un autre.

### Duplication de composants

Un même composant peut être affiché plusieurs fois dans la même page.
Il faut alors donner à chaque instance du composant un identifiant différent, qui sera ensuite utilisé pour les distinguer.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class), 'first') ?>>
</div>

<div class="row" <?= attr()->bind(rq(UiComponent::class), 'second') ?>>
</div>
```

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doB()
    {
        // Afficher le composant avec l'identifiant "second"
        $this->cl(UiComponent::class)->item('second')->render();
    }
}
```

### Helpers pour les fenêtres et alertes

Le trait `Jaxon\App\Dialog\DialogTrait` founit les méthodes `alert()` et `dialog()` qui affichent [les dialogues et les messages](../../ui-features/dialogs.html) dans la page.

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
