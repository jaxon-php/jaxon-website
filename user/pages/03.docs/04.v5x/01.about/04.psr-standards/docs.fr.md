---
title: Les standards PSR supportés
menu: Les standards PSR
template: jaxon
---

Jaxon supporte les standards PSR [Container interface (PSR-11)](https://www.php-fig.org/psr/psr-11), [HTTP Message interfaces (PSR-7)](https://www.php-fig.org/psr/psr-7), [HTTP Handlers (PSR-15)](https://www.php-fig.org/psr/psr-15), et [HTTP Factories (PSR-17)](https://www.php-fig.org/psr/psr-17).

### PSR-11: Container interface

Le conteneur DI de Jaxon implémente l'interface `Psr\Container\ContainerInterface` du standard `PSR-11`.
La fonction `jaxon()->di()` retourne donc un objet compatible avec cette interface.

L'interface `Psr\Container\ContainerInterface` est également utilisée pour combiner le conteneur de Jaxon au conteneur des frameworks dans lesquels la librairie est intégrée.
C'est ce qui permet d'injecter des services définis dans le conteneur du framework dans les composants de Jaxon.

### PSR-7: HTTP Message Interface

Dans la librairie Jaxon et dans ses plugins de requête, la requête HTTP reçue en entrée de l'application implémente l'interface `Psr\Http\Message\ServerRequestInterface`, définie par le standard PSR-7.

Cette interface fournit des fonctions pour lire, dans la requête HTTP, les arguments, les paramètres, et les fichiers uploadés.

Les classes Jaxon renvoient toujours un objet de type `Jaxon\Response\ResponseInterface`, mais celui-ci possède une méthode `toPsr()` qui le transforme en un objet qui implémente l'interface `Psr\Http\Message\ResponseInterface`, définie par le standard PSR-7.

### PSR-17: HTTP Factories

Jaxon utilise un package tiers qui implémente le standard PSR-17,
[nyholm/psr7-server](https://github.com/nyholm/psr7-server), pour lire les requêtes HTTP qu'il reçoit.

Ce package fournit les fonctions pour créer, à partir du contenu de la requête HTTP, un objet qui implémente l'interface `Psr\Http\Message\ServerRequestInterface` définie par le standard PSR-7.
Cet objet est lui-même défini dans le package [nyholm/psr7](https://github.com/Nyholm/psr7).

### PSR-15: HTTP Handlers

De plus en plus de frameworks PHP supportent le standard PSR-15, qui définit des interfaces pour deux types de composants qui traitent les requêtes HTTP:
- les middlewares: `Psr\Http\Server\MiddlewareInterface`,
- les request handlers: `Psr\Http\Server\RequestHandlerInterface`.

Jaxon fournit deux `middlewares` et un `request handler`.

Le middleware `jaxon()->psr()->config($filename)` prend en paramètre le chemin vers un fichier de configuration, et initialise la librairie avec son contenu.

Le middleware `jaxon()->psr()->ajax()` et le handler `jaxon()->psr()->handler()` traitent la requête Jaxon, et renvoient en réponse un objet qui implémente l'interface `Psr\Http\Message\ResponseInterface`.
Un seul des deux sera donc utilisé dans une même application PHP.

Ces composants servent à intégrer Jaxon dans les frameworks PHP qui supportent le standard PSR-15, à l'exemple de [Slim Framework](../../integrations/slim.html).
