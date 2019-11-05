---
title: Le cycle de vie d'une requête Jaxon
menu: Le cycle de vie d'une requête
template: jaxon
---

1. Au départ, il y a une classe PHP définie par le développeur. Lorsque cette classe est enregistrée dans la librarie Jaxon, une classe javascript du même nom (et un préfixe configurable), est créée et incluse dans la page web.

2. Lorsque la classe javascript est appelée dans le navigateur, une requête Ajax est automatiquement créée et envoyée vers l'application. La requête a comme paramètres les noms de la classe et la méthode PHP, et les paramètres reçus.

3. La librairie Jaxon reçoit cette requête, et appelle la classe PHP en lui passant les paramètres reçus.<br/>

4. La classe PHP écrite par le développeur renvoie un objet `Response`, dans laquelle elle a enregistré une série de commandes à exécuter dans le navigateur.

5. La librairie Jaxon renvoie cette réponse au navigateur, qui exécute automatiquement toutes les commandes qu'elle contient.

Les étapes 2, 3 et 5 sont entièrement gérées par Jaxon, et transparentes pour le développeur.
Son seul rôle est d'écrire les fonctions PHP qui définissent le contenu et la présentation de la page web.

&Agrave; la fin, un appel Ajax permet d'exécuter une série d'actions, définies dans l'application avec PHP, dans une page web.
