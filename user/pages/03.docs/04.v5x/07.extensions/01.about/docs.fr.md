---
title: Etendre la librairie
menu: Les extensions
template: jaxon
---

L'architecture de la librairie Jaxon est modulaire.
Plusieurs de ses fonctions sont conçues sous forme d'extensions qui se greffent au coeur de la librairie.
C'est par exemple le cas des fonctions de déclaration des classes et des fonctions à exporter, ou encore des databags et de la pagination.

Les fonctions de la librairie peuvent dont être enrichies avec plusieurs types d'extensions.

Les [plugins de réponse](../response.html) sont les plus communs. Ils ajoutent de nouvelles fonctionnalités à l'objet `Response`, et fournissent des fonctions avancées d'UI, telles que les dialogues ou l'upload.

Les [plugins de requête](../request.html) sont moins fréquents. Ils ajoutent à la librairie de nouveaux types d'objets à enregistrer, en plus des classes et des fonctions, ils génèrent le code Javascript correspondant, et traitent les requêtes Ajax vers ces objets.

Les [extensions de vues](../views.html) connectent les moteurs de templates à l'API d'affichage des vues de Jaxon.

Le [plugin Dialogs](../../ui-features/dialogs.html) est un cas spéciial dans l'univers Jaxon. C'est un [plugin de réponse](../response.html), mais qui peut ête étendu avec [ses propres plugins](../dialogs.html).

Les [extensions d'intégration](../../integrations/about.html) n'enrichissent pas les fonctions de la librairie, mais servent plutôt à simplifier son utilisation avec les frameworks ou les CMS PHP les plus courants, tels Laravel ou Symfony.

Les [packages](../packages.html) sont des modules logiciels complets qui implémentent les fonctions backend et frontend d'une solution. Ils sont destinés à être intégrés dans une page d'une application PHP existante.

#### Les interfaces communes aux plugins

Chaque type d'extension doit implémenter certaines interfaces spécifiques.
Deux interfaces cependant sont communes à plusieurs types d'extensions.

L'interface `Jaxon\Plugin\PluginInterface` est obligatoire pour les plugins de requête et les plugins de réponse.
Elle définit un nom pour le plugin.

```php
namespace Jaxon\Plugin;

interface PluginInterface
{
    /**
     * Get a unique name to identify the plugin.
     *
     * @return string
     */
    public function getName(): string;
}
```

L'interface `Jaxon\Plugin\CodeGeneratorInterface` peut être implémentée par toute extension qui doit ajouter du code Javascript ou CSS à l'application.
Elle définit les fonctions qui génèrent ces codes.

```php
namespace Jaxon\Plugin;

use Jaxon\Plugin\Code\JsCode;

interface CodeGeneratorInterface
{
    /**
     * Get the value to be hashed
     *
     * @return string
     */
    public function getHash(): string;

    /**
     * Get the HTML tags to include CSS code and files into the page
     *
     * The code must be enclosed in the appropriate HTML tags.
     *
     * @return string
     */
    public function getCss(): string;

    /**
     * Get the HTML tags to include javascript code and files into the page
     *
     * The code must be enclosed in the appropriate HTML tags.
     *
     * @return string
     */
    public function getJs(): string;

    /**
     * Get the javascript code to include into the page
     *
     * The code must NOT be enclosed in HTML tags.
     *
     * @return string
     */
    public function getScript(): string;

    /**
     * Get the javascript codes to include into the page
     *
     * The code must NOT be enclosed in HTML tags.
     *
     * @return JsCode|null
     */
    public function getJsCode(): ?JsCode;
}
```
