---
title: Générer le code javascript
menu: Le code javascript
template: jaxon
---

Une fois que les fonctions et les objets PHP ont été exportés, la dernière étape consiste à générer le code à insérer dans les pages HTML.
Jaxon fournit 3 fonctions différentes pour générer le code à envoyer au navigateur.

- La fonction `$jaxon->getCss()` renvoie le code CSS à insérer dans la page. Il s'agira très souvent des instructions de chargement des fichiers CSS des plugins Jaxon.
- La fonction `$jaxon->getJs()` le code de chargement des fichiers javascript externes.
- La fonction `$jaxon->getScript()` renvoie le code javascript correspondant aux fonctions et classes exportées, et à la configuration de la librairie.

La séparation en 3 fonctions distinctes permet d'afficher les codes générés par la librairie Jaxon dans des parties différentes de la page HTML.  
L'appel `$jaxon->getScript(true, true)` renvoie la sortie cumulée des 3 appels précédents.
