---
title: Générer le code javascript
menu: Le code javascript
template: jaxon
---

Une fois que les classes PHP ont été enregistrées, l'étape suivante consiste à générer le code javascript correspondant.
Jaxon fournit 3 fonctions différentes pour cela.

- La fonction `$jaxon->getCss()` renvoie le code CSS à insérer dans la page. Il s'agira très souvent des instructions de chargement des fichiers CSS des plugins Jaxon.
- La fonction `$jaxon->getJs()` le code de chargement des fichiers javascript externes.
- La fonction `$jaxon->getScript()` renvoie le code javascript correspondant aux fonctions et classes enregistrées, et à la configuration de la librairie.

La séparation en 3 fonctions distinctes permet d'afficher les codes générés par la librairie Jaxon dans des parties différentes de la page HTML.
L'appel `$jaxon->getScript(true, true)` renvoie la sortie cumulée des 3 appels précédents.

#### Le code Javascript

Lorsque l'option `js.app.extern` a la valeur `false`, la fonction `$jaxon->getScript()` renvoie le code javascript, qui sera donc directement inclus dans le code HTML de la page.

Si cette option a la valeur `true`, le code javascript est enregistré dans un fichier dans le répertoire indiqué par l'option `js.app.dir`,
et la fonction `$jaxon->getScript()` renvoie le code HTML pour charger ce fichier à partir de l'URL indiquée par l'option `js.app.uri`.
Si en plus l'option `js.app.minify` a la valeur `true`, le code javascript est minifié et le nom du fichier se termine par `.min.js`.

Le fichier javascript n'est plus généré s'il existe déjà.
Il est donc conseillé de mettre l'option `js.app.extern` à `false` pendant le développement, et de générer un fichier minifié lorsque l'application est déployée.
