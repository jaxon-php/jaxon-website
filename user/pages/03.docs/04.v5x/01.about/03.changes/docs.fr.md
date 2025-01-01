---
title: Nouvelles fonctions dans la version 5
menu: Nouvelles fonctions
template: jaxon
---

### Les composants d'UI

Le principal changement dans la version 5 de Jaxon, qui est une innovation dans son genre, est l'introduction des composants d'UI.

Un [composant](../../components/node-components.html) est une classe PHP est [attachée à un noeud du DOM](../../components/dom-bindings.html) dans le code HTML.
Elle fournit une méthode `html()` qui renvoie un code HTML, et une méthode `render()` qui, lorsqu'elle est appelée dans une fonction Ajax, va remplacer le contenu du noeud du DOM par la valeur renvoyée par la fonction `html()`.

Combinée aux [databags](../../components/databags.html) et aux [stashes](../../components/stashes.html), qui permettent de partager des données entre le navigateur et le serveur, et entre différents composants de l'application, cette fonctionnalité permet de contruire facilement des UI complexes en Ajax et PHP.

### Les templates

De nouvelles fonctions de [templating](../../components/templating.html) ont été ajoutées pour attacher les [composants](../../components/node-components.html) aux noeuds du DOM, définir les gestionnaires d'évènements, mais aussi pour intégrer les codes Javascript et CSS générés par la librairie dans la page web.

En plus des templates, l'api PHP et Javascript de [la `request factory`](../../call-factory/requests.html), qui génère les appels à des fonctions et sélecteurs Javascript (ou jQuery) et les associe à des évènements dans la page web, a été grandement améliorée.

### Re-écriture des commandes

Les noms et les formats des commandes contenues dans les objets `Response` ont été modifiés.
Les noms des commandes et de leurs paramètres sont désormais plus explicites (`node.assign` au lieu de `as` par exemple).

Des commandes obsoletes ont été supprimées. Il s'agit de celles qui permettaient d'inclure dynamiquement des fonctions Javascript ou des fichiers Javascript ou CSS dans la page.
Les outils de frontend modernes sont de meilleures alternatives à ces fonctions.

### La classe `Response`

La [classe `Response`](../../requests/responses.html) ne stocke plus les commandes, et ses instances servent désormais de proxy à un objet gestionnaire de commandes.
Par conséquent, les fonctions des classes Jaxon ne sont plus tenues de renvoyer un objet `Response`.

La sntaxe de la fonction `confirm()` de la classe `Response` a également été modifiée.

### La gestion de la configuration

Un [nouveau package](https://github.com/jaxon-php/jaxon-config) a été créé pour gérer les options de configuration, qui sont désormais stockés dans des objets immutables.

### Upload avec iframe

Cette fonction, qui permettait l'upload en Ajax dans les navigateurs qui ne le supportent pas nativement, a été supprimée.

### Les attributs dans les classes Jaxon (en cours de développement)

Le package [jaxon-annotations](https://github.com/jaxon-php/jaxon-annotations) permet actuellement d'utiliser certaines fonctions dans les classes Jaxon à l'aide d'annotations, telle que `@upload`.

Le package [jaxon-attributes](https://github.com/jaxon-php/jaxon-attributes) fournit les mêmes fonctions, mais en utilisant les attributs.
Cependant, il est encore en cours de développement.

### Développement en monorepo

La librairie Jaxon est désormais [développée dans un monorepo](https://github.com/jaxon-php/jaxon-mono).
Les dépôts de tous les packages présents dans ce monorepo sont donc désormais accessibles uniquement en lecture.

### Re-écriture du code Javascript

Une grande partie de la librairie Javascript a été re-écrite, pour s'adapter aux nombreux changements apportés à la librairie PHP.

Cela inclut notamment un nouveau parseur qui interprète et exécute les commandes contenues dans les réponses aux requêtes Ajax, dans leur nouveau format json.

### Les plugins de dialogue

La structure des [plugins de dialogue](../../features/dialogs.html) a été simplifiée, et leur code est désormais écrit uniquement en Javascript.
Les classes PHP servent uniquement à les déclarer et à inclure leurs codes Javascript et CSS dans la page.

### Alternatives à jQuery

La librairie Jaxon utilise certaines fonctions spécifiques à `jQuery`, comme les sélecteurs et les gestionnaires d'évènements.
Pour ceux qui ne souhaitent pas utiliser `jQuery`, il est possible de prendre à la place une alternative plus lègère.

Actuellement, la [librairie Chibi.js](https://github.com/kylebarrow/chibi) est supportée, et il est possible que d'autres le soient à l'avenir.
