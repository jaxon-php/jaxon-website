---
title: 'Introduction à Jaxon'
date: '04-05-2020 07:00'
media:
    images:
        - javier-garcia-chavez-unsplash.jpg
taxonomy:
    category:
        - blog
    tag:
        - php
        - javascript
        - ajax
---

La version 2.0.0 stable de la librairie Jaxon vient d'être livrée. Elle apporte son lot de nouveautés, parmi lesquelles la gestion des vues et des sessions, une API semblable à jQuery pour mettre à jour le contenu des pages, et les packages Armada et Sentry, qui fournissent des fonctions plus avancées et un socle commun pour les packages d'intégration avec les frameworks PHP.

Cet article présente les évolutions de la librairie depuis sa version 1, avec un focus sur l'architecture de la version 2, et les nouvelles fonctions qui y ont été ajoutées. C'est le premier d'une série d'articles sur Jaxon. Les suivants, plus techniques, présenteront les fonctions les plus importantes de la librairie.

1. Un peu d'histoire

[Jaxon](https://www.jaxon-php.org) est un fork de la [librairie PHP Xajax](http://www.xajax-project.org), qui a apporté une façon unique et originale de créer des applications Ajax avec PHP. Elle permet d'une part de générer des appels Ajax en Javascript vers des classes PHP, et d'autre part de changer le contenu et la présentation de la page dans ces classes PHP (server-side rendering). La programmation d'une application Ajax devient très simple avec Xajax, car un appel Javascript suffit pour exécuter les actions les plus complexes sur la page web, ces actions étant programmées en PHP sur le serveur.
Malheureusement, le développement de la librairie s'est arrêté en 2012, peu après la sortie de la version 0.6, pour des raisons qui restent inconnues.

Une nouvelle version de la librairie a d'abord été publiée sur Github en février 2016, et en mars elle est renommée en Jaxon et publiée pour la première fois sous ce nom. Peu après, en juillet 2016, la version 1.0.0 est sortie. Elle reprenait les principales fonctions de Xajax, mais avec un code entièrement ré-écrit, la séparation de la librairie en un package Javascript et plusieurs packages PHP, l'utilisation de Composer pour l'installation, et quelques plugins. En fin décembre 2016, sortait la première release beta de la version 2. 7 mois, 117 commits et 28 releases plus tard, elle sort enfin en version 2.0.0 stable.

2. Les nouveautés de Jaxon

Dans la version 1, la principale nouveauté est la possibilité d'enregistrer avec une seule ligne de code les classes PHP se trouvant dans un répertoire, éventuellement en prenant en compte leur namespace. De plus, la configuration de la librairie peut être chargée à partir d'un fichier, et les fonctions pour générer le code Ajax qui appelle les classes PHP s'enrichissent, en particulier avec le support des répertoires, des namespaces, et de la pagination.

Les principales nouveautés de la version 2 sont les packages Armada et Sentry, la gestion des vues et des sessions, et l'API jQuery-PHP. Des tests unitaires ont également été ajoutés à la librairie, bien que la couverture reste à améliorer.

Les packages [Armada et Sentry](https://www.jaxon-php.org/fr/docs/armada/operation.html) offrent une classe de base dont héritent les classe des applications, et qui leur fournit de nombreuses fonctions. Ils offrent également une API commune pour la gestion des vues et des sessions, qui s'appuie sur les fonctions des frameworks ou d'autres librairies PHP. L'API jQuery-PHP fournit des fonctions inspirées de la librairie Javascript jQuery pour mettre à jour le contenu des pages de l'application en PHP.

L'avantage le plus important de Armada et Sentry est la possibilité de réutiliser les classes de son application Jaxon avec différents frameworks PHP.

3. Les packages de Jaxon

4 packages constituent le coeur de la librairie Jaxon. Les autres sont des plugins qui lui ajoutent des fonctions, ou l'intègrent à des frameworks PHP.

Les principaux packages sont:
- jaxon-core et jaxon-js, qui fournissent respectivement les fonctions PHP et Javascript.
- jaxon-sentry et jaxon-armada, qui fournissent les fonctions les plus avancées, et un socle commun pour l'intégration avec les frameworks PHP.

Les packages d'intégration simplifient l'utilisation de Jaxon avec les frameworks PHP les plus courants. Ils se présentent sous la forme d'un plugin pour le framework concerné, avec des fonctions pour charger la configuration de Jaxon à partir d'un fichier au format défini par le framework, et pour charger les classes Jaxon à partir d'un répertoire et d'un namespace prédéfinis. Ils fournissent également un adaptateur qui permet d'utiliser l'API de gestion des vues et des sessions de Jaxon avec les fonctions fournies par le framework.

Un seul package d'intégration peut être utilisé dans une application, en fonction du framework utilisé. Pour les frameworks qui ne sont pas encore supportés, le package jaxon-armada doit être utilisé.

Des packages d'intégration existent actuellement pour 6 frameworks PHP:
- Symfony : https://github.com/jaxon-php/jaxon-symfony
- Laravel : https://github.com/jaxon-php/jaxon-laravel
- Zend Framework : https://github.com/jaxon-php/jaxon-zend
- Cake PHP : https://github.com/jaxon-php/jaxon-cake
- CodeIgniter : https://github.com/jaxon-php/jaxon-codeigniter
- Yii : https://github.com/jaxon-php/jaxon-yii

Les packages Armada et Sentry fournissent une API de vues unique, qui peut être utilisée avec différents moteurs de templates. Dans une application Jaxon, les vues qui utilisent un moteur de templates donné sont placées dans un répertoire, qui est ensuite indiqué dans la configuration, avec l'identifiant du moteur.

```php
    'app' => array(
        'views' => array(
            'users' => array(
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ),
        ),
    ),
```

L'identifiant est ensuite utilisé dans les classes Jaxon pour afficher les templates avec le moteur choisi.

```php
    // Afficher la vue /path/to/users/views/path/to/view.tpl avec Smarty
    $html = $this->view()->render('users::path/to/view');
```

Le support de chaque moteur de templates est implémenté dans un package distinct, dont plusieurs peuvent être utilisés dans une même application:
- Twig https://github.com/jaxon-php/jaxon-twig.
- Smarty https://github.com/jaxon-php/jaxon-smarty.
- Blade https://github.com/jaxon-php/jaxon-blade.
- Dwoo https://github.com/jaxon-php/jaxon-dwoo.
- Latte https://github.com/jaxon-php/jaxon-latte.
- RainTpl https://github.com/jaxon-php/jaxon-raintpl.

Enfin, le package jaxon-dialogs offre une API unique qui peut être utilisée avec différentes librairies Javascript pour afficher des fenêtres, des dialogues de confirmation et des notifications. Au moment de l'écriture de cet article, 16 librairies Javascript sont supportées, et chaque utilisateur peut en ajouter de nouvelles.

4. Armada et Sentry

Les packages Armada et Sentry sont au coeur de cette nouvelle version 2. Le package Sentry fournit les classes et les interfaces qui implémentent ou définissent toutes les fonctionnalités de la librairie, que ce soit pour la gestion des classes de l'application, ou encore pour la gestion des vues et des sessions. Cependant, il n'est pas prévu pour être utilisé directement par les développeurs. C'est donc le package Armada, qui repose sur Sentry, qui au final va leur offrir toutes ces fontionnalités.

Il est à noter que les packages d'intégration aux frameworks PHP reposent également sur le package Sentry. Par conséquent, cela permet d'avoir des API communes pour les applications Jaxon, qu'elles utilisent Armada ou qu'elles soient intégrées à un framework PHP. En particulier, une classe d'une application qui utilise ces API pourra être réutilisée sans être modifiée avec Armada et avec des frameworks PHP.

Cette propriété est très intéressante car elle ouvre la voie à la création de modules applicatifs complets, avec des fonctions de sessions et de vues, qui peuvent être compatibles avec plusieurs frameworks PHP différents. Cela n'était pas possible jusqu'aujourd'hui.
Un exemple d'un tel module serait une application de gestion des utilisateurs.

5. Les classes de l'application

Les classes d'une application Jaxon Armada peuvent être réparties dans plusieurs répertoires, chacun ayant un namespace distinct. Tous les répertoires sont déclarés dans la section app.classes du fichier de configuration.

Les classes héritent de la classe Jaxon\Sentry\Armada, qui fournit un grand nombre de fonctions qui vont servir à construire l'application.
- La mise à jour du contenu et de la présentation des pages de l'application. Ce sont les fonctions qui permettent de manipuler le DOM (Document Object Model) d'une page web, c'est-à-dire de modifier son contenu (HTML) ou sa présentation (CSS).
- La création des requêtes Ajax vers les classes de l'application. Ces fonctions génèrent le code Javascript nécessaire pour appeler les classes PHP de l'application directement depuis la page web, et aussi pour lier ce code à des évènements sur les éléments de la page.
- La gestion des vues et des sessions.

Toutes ces fonctions sont définies ou implémentées dans le package Sentry, qui sert de socle commun au package Armada et à tous les autres packages d'intégration des frameworks PHP. Par conséquent, une classe d'une application Armada peut être utilisée avec n'importe quel framework PHP supporté, sans avoir besoin de modification.

6. Les futurs développements

Ils vont se porter sur trois axes principaux: enrichir l'écosystème de la librairie avec plus de plugins, la rendre plus fiable avec plus de tests, et enfin moderniser sa librairie Javascript.

Sur le premier point, deux nouveaux plugins sont actuellement en projet. Le premier est un plugin pour afficher des graphes dans une page web avec plusieurs librairies Javascript au choix. Il s'inspire du package Charts pour Laravel (https://github.com/ConsoleTVs/Charts). Le second est un module complet de gestion des utilisateurs similaire à Voyager (https://laravelvoyager.com) ou LaraAdmin (http://laraadmin.com), quoiqu'avec beaucoup moins de fonctionnalités. Basé sur Armada et Sentry, il permettra de démontrer la création de modules cross-framework avec Jaxon.

Actuellement, seule une portion du code de la librairie est couverte par des tests unitaires. L'objectif sera d'augmenter la couverture de tests, et aussi d'ajouter des tests fonctionnels, afin qu'il soit possible de valider le bon fonctionnement de la librairie au niveau d'une page web.

Enfin, contraitement au code PHP, le code Javascript de la librairie n'a pas beaucoup évolué. Il serait par exemple intéressant d'utiliser un ou plusieurs micro-frameworks (http://microjs.com) pour implémenter certaines de ses fonctions, avec l'objectif de réduire sa taille mais aussi de lui ajouter des tests.
