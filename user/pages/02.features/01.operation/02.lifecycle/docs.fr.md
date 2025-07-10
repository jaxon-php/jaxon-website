---
title: Le cycle de vie d'une requête Jaxon
menu: Le cycle de vie d'une requête
template: jaxon
---

![Jaxon operation](/images/jaxon-operation.png)

1. Au départ, le développeur crée des classes PHP qu'il exporte avec la librairie Jaxon. Une classe javascript du même nom et avec les mêmes fonctions est créée pour chaque classe PHP, et incluse dans la page web.

2. Lorsqu'une fonction d'une classe javascript est appelée dans le navigateur, la même fonction dans la classe PHP sera appelée sur le serveur, avec les mêmes paramètres.

3. En réalité, une requête Ajax est automatiquement créée et envoyée vers l'application. Elle contient les noms de la classe et la méthode, et des paramètres. La librairie Jaxon reçoit cette requête, et appelle la classe PHP en lui passant les paramètres reçus.

La classe PHP va ensuite remplir un objet `Response` avec série de commandes à exécuter dans le navigateur.

4. La librairie Jaxon renvoie cette réponse au navigateur, qui exécute automatiquement les commandes qu'elle contient.

Les étapes 3 et 4 sont gérées par Jaxon, et transparentes pour le développeur.
Son seul rôle est d'écrire les fonctions PHP qui définissent le contenu et la présentation de la page web.

&Agrave; la fin, un seul appel Ajax permet d'exécuter une série d'actions, définies dans l'application côté serveur avec PHP, dans une page web.
