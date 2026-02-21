---
title: Etendre la librairie
menu: Les extensions
template: jaxon
---

L'architecture de la librairie Jaxon est modulaire.
Plusieurs de ses fonctions sont conçues sous forme d'extensions qui se greffent au coeur de la librairie.
C'est par exemple le cas des fonctions de déclaration des classes et des fonctions à exporter, ou encore des databags.

Les fonctions de la librairie peuvent dont être enrichies avec plusieurs types d'extensions.

Les [plugins de réponse](../response.html) sont les plus communs. Ils ajoutent de nouvelles fonctionnalités à l'objet `Response`, et fournissent des fonctions avancées d'UI, telles que les dialogues ou l'upload.

Les [plugins de requête](../request.html) sont moins fréquents. Ils ajoutent à la librairie de nouveaux types d'objets à enregistrer, en plus des classes et des fonctions.
Ils génèrent ensuite le code Javascript correspondant, et traitent les requêtes Ajax vers ces objets.

Les [extensions de vues](../views.html) connectent les moteurs de templates à l'API d'affichage des vues de Jaxon.

Le [plugin Dialogs](../../ui-features/dialogs.html) est un cas spéciial dans l'univers Jaxon. C'est un [plugin de réponse](../response.html), mais qui peut ête étendu avec [ses propres plugins](../dialogs.html).

Les [extensions d'intégration](../../integrations/about.html) n'enrichissent pas les fonctions de la librairie, mais servent plutôt à simplifier son utilisation avec les frameworks ou les CMS PHP les plus courants, tels Laravel ou Symfony.

Les [packages](../packages.html) sont des modules logiciels complets qui implémentent les fonctions backend et frontend d'une solution. Ils sont destinés à être intégrés dans une page d'une application PHP existante.

#### Les interfaces des extensions

La librairie Jaxon définit plusieurs interfaces que les classes des extentions doivent implémenter, selon les fonctions qu'elles fournissent.

L'interface `Jaxon\Plugin\PluginInterface` est commune aux plugins de réponse et de requête.

Les plugins de réponse doivent en plus implémenter l'interface `Jaxon\Plugin\ResponsePluginInterface`.
Ces interfaces sont regroupées dans la classe abstraite `Jaxon\Plugin\AbstractResponsePlugin`.

Les plugins de requête doivent implémenter l'interface `Jaxon\Plugin\CallableRegistryInterface` lorsqu'ils doivent déclarer des classes qui peuvent être appelées dans une requête Ajax, et `RequestHandlerInterface` lorsqu'ils peuvent traiter une requête.
Ces interfaces sont regroupées dans la classe abstraite `Jaxon\Plugin\AbstractRequestPlugin`.

Les extensions de vues doivent implémenter l'interface `Jaxon\App\View\ViewInterface`.
Les packages doivent hériter de la classe abstraite `Jaxon\Plugin\AbstractPackage`, mais n'ont aucune interface à implémenter.

### Les interfaces de generation de code

Indépendamment des interfaces des extensions, la librairie fournit des interfaces spécifiques pour les extensions qui génèrent du code Javascript ou CSS.
Ce sont les interfaces `Jaxon\Plugin\JsCodeGeneratorInterface` et `Jaxon\Plugin\CssCodeGeneratorInterface`.

En plus de la fonction `getHash()`, chacune définit une fonction `getJsCode()` ou `getCssCode()`, qui doit renvoyer un objet `Jaxon\Plugin\JsCode` ou `Jaxon\Plugin\CssCode`.
L'implémentation des fonctions de génération de code consistera donc à créer une instance de l'une de ces classes et remplir ses propriétés avec le code de l'extension.

> Note: l'interface `Jaxon\Plugin\CodeGeneratorInterface` est dépréciée.
