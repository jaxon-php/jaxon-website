---
title: Comment ça marche
menu: Comment ça marche
template: docs
---

1. Au départ, il y a une fonction PHP définie par le développeur, qui souhaite l'appeler depuis le navigateur. Lorsque cette fonction est exportée, la librarie Jaxon crée une fonction javascript correspondante, qui sera intégrée à la page web.

2. Lorsque la fonction javascript est appelée dans le navigateur, une requête Ajax est créée et envoyée vers le serveur. La requête a comme paramètres le nom de la fonction PHP correspondante, et les paramètres qui lui ont été passés. La librairie Jaxon reçoit cette requête, et appelle la fonction PHP en lui passant les paramètres reçus. Cette partie est entièrement gérée par Jaxon, et transparente pour le développeur.

3. La fonction Jaxon crée et renvoie une réponse Jaxon, dans laquelle elle enregistre une série de commandes à exécuter dans le navigateur.

4. La librairie Jaxon récupère cette réponse et la retransmet au navigateur, qui exécute automatiquement toutes les commandes qu'elle contient.
