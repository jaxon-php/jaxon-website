---
title: Le cycle de vie d'une requête Jaxon
menu: Principe de fonctionnement
template: jaxon
published: false
---

1. Au départ, il y a une classe PHP définie par le développeur. Lorsque cette classe est exportée avec la librarie Jaxon, une classe javascript du même nom (et un préfixe configurable), est créée et intégrée à la page web.

2. Lorsque la classe javascript est appelée dans le navigateur, une requête Ajax est automatiquement créée et envoyée vers le serveur. La requête a comme paramètres le nom de la classe PHP, et les paramètres reçus. La librairie Jaxon reçoit cette requête, et appelle la classe PHP en lui passant les paramètres reçus.<br/>
Cette partie est entièrement gérée par Jaxon, et transparente pour le développeur.

3. La classe Jaxon écrite par le développeur renvoie un objet `Response`, dans laquelle elle a enregistré une série de commandes à exécuter dans le navigateur.

4. La librairie Jaxon renvoie cette réponse au navigateur, qui exécute automatiquement toutes les commandes qu'elle contient.

&Agrave; la fin, un seul appel javascript dans une page web permet d'exécuter n'importe quelle série d'actions, qui sont définies côté serveur avec PHP.
