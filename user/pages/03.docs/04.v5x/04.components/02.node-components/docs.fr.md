---
title: Les composants d'UI
menu: Composants d'UI
template: jaxon
---

Les components d'UI sont une nouveauté de la version 5 de Jaxon.

Ils ont les mêmes fonctions que les [composants fonctionnels](../func-components.html), mais en plus ils peuvent être attachés à un noeud du DOM. Ils vont alors servir à gérer le contenu de ce noeud.

```php
<div class="row" <?= attr()->bind(rq(UiComponent::class)) ?>>
</div>
```

Un composant peut également être attaché à un noeud dynamiquement.

```php
$this->response->bind('element-id', rq(UiComponent::class));
```

Les composants d'UI héritent de la classe `Jaxon\App\NodeComponent`, qui les oblige a implémenter une fonction `public function html(): string|Stringable` qui renvoie le contenu du noeud attaché.


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

#### Afficher un composant

Le composant d'UI possède une fonction `render()`, qui va être appelée pour mettre à jour le contenu du noeud attaché, dans une méthode du même composant, ou d'un autre composant.

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
        $this->cl(UiComponent::class)->render();
    }
}
```

La méthode `render()` d'un composant d'UI est exportée en Javascript, et peut donc être liée à des évènements de l'UI dans une méthode,

```php
class FuncComponent extends \Jaxon\App\FuncComponent
{
    public function doA()
    {
        $this->response->jq('#btn-refresh')
            ->on('click', $this->rq(UiComponent::class)->render());
    }
}
```

ou bien dans un template.

```php
<button type="button" class="btn btn-primary" <?php
    echo attr()->click(rq(UiComponent::class)->render()) ?>>Clear</button>
```

#### Affichages multiples

Un même composant peut être affiché plusieurs fois dans la même page.
Il faut alors donner à chaque instance du composant un identifiant d'item différent, qui sera ensuite utilisé pour les distinguer.

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

#### L'objet `NodeResponse`

La classe `Jaxon\App\NodeComponent` possède une méthode `node()` qui retourne une réponse spéciale, qui est liée au noeud attaché.

Les [fonctions de manipulation du contenu et du style](../../features/responses.html) de cet objet ne possèdent plus le paramètre `string $sTarget`, car elles vont agir uniquement sur le noeud attaché.

#### Les autres fonctions des composants d'UI

La fonction `clear()` supprime le contenu du noeud attaché de la page.

La fonction `visible(bool $visible)`, selon le paramètre booléen qu'elle reçoit, affiche ou cache le noeud attaché, sans modifier son contenu.

Les fonctions `protected function before()` et `protected function after()` sont appelée respectivement avant et après l'affichage du composant dans la fonction `render()`.
Elles servent généralement à préparer ou à compléter l'affichage du composant, soit en allant chercher des données, soit en affichant d'autres composants.
