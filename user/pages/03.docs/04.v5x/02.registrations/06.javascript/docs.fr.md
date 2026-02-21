---
title: Générer le code javascript et CSS
menu: Le code javascript et CSS
template: jaxon
---

Une fois que les classes PHP ont été enregistrées, l'étape suivante consiste à générer le code javascript et CSS correspondant.
Jaxon fournit 3 fonctions différentes pour cela.

- La fonction `jaxon()->getCss()` renvoie le code CSS à insérer dans la page. Il s'agira très souvent des instructions de chargement des fichiers CSS des plugins Jaxon.
- La fonction `jaxon()->getJs()` le code de chargement des fichiers javascript externes.
- La fonction `jaxon()->getScript()` renvoie le code javascript correspondant aux fonctions et classes enregistrées, et à la configuration de la librairie.

La séparation en 3 fonctions distinctes permet d'afficher les codes générés par la librairie Jaxon dans des parties différentes de la page HTML.
L'appel `jaxon()->getScript(true, true)` renvoie la sortie cumulée des trois appels précédents.

### Écrire le code Javascript dans un fichier

Lorsque l'option `js.app.export` a la valeur `false`, le code javascript et CSS généré par la librairie est directement inclus dans le code HTML de la page.

Si cette option a la valeur `true`, des fichiers `.js` et `.css` sont créés dans le répertoire indiqué par l'option `js.app.dir`,
et les fonctions `jaxon()->getScript()` et `jaxon()->getCss()` renvoie le code HTML pour charger ces fichiers à partir de l'URL indiquée par l'option `js.app.uri`.
Si en plus l'option `js.app.minify` a la valeur `true`, le code est minifié et le nom des fichiers se termine par `.min.js` et `.min.css`.

Par défaut, le nom des fichiers est généré avec un hash sur une valeur calculée par la librairie.
Si l'option `js.app.file` est définie, sa valeur est utilisée comme nom de fichier.

Les fichiers javascript et CSS ne sont plus générés s'ils existent déjà.
Il est donc conseillé de mettre l'option `js.app.export` à `false` pendant le développement, et de générer des fichiers minifiés lorsque l'application est déployée.
