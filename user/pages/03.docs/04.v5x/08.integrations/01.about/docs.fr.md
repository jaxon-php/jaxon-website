---
title: Extensions d'intégration de framework
menu: Extensions d'intégration
template: jaxon
---

Jaxon fournit des extensions pour faciliter son intégration avec les frameworks PHP les plus courants.

Ces extensions Jaxon utilisent les fonctionnalités du framework pour :
- Bootstrapper la librairie à partir d'un fichier de configuration au format du framework.
- Créer une route et un contrôleur (ou un middleware) pour traiter les requêtes Jaxon.
- Convertir la réponse à renvoyer au navigateur au format du framework.

Les extensions vont également fournir des fonctions de proxy pour:
- Les logs : les messages écrits avec les [fonctions de logging](../../features/logging.html) de Jaxon vont dans le système de logs du framework.
- Les vues : les [fonctions de vues](../../ui-features/views.html) de Jaxon affichent les templates définis dans le framework.
- Le conteneur : les services définis dans le conteneur de dépendances du framework peuvent être [injectés dans les classes Jaxon](../../features/dependency-injection.html).
- Les sessions : les [fonctions de sessions](../../features/sessions.html) de Jaxon permettent de lire et écrire des valeurs dans les sessions du framework.

Enfin, pour les vues, les extensions définissent des fonctions pour y insérer les codes Javascript et CSS de Jaxon, et des [call factories](../../ui-features/call-factories.html).
