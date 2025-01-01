---
title: Migrer de la version 3
menu: Migrer de la version 3
template: jaxon
---

Les principales fonctions à mettre à jour pour migrer de la version 3 sont:

- la classe `Jaxon\App\CallableClass`
- le namespace pour les fonctions globales
- la création des objets `Response`
- l'upload de fichiers
- la création de plugins

Optionnellement, les fonctions suivantes peuvent être améliorées grâce aux nouvelles annotations:

- l'injection de dépendance
- les data bags
- l'upload de fichiers

## La classe `Jaxon\App\CallableClass`

La classe `Jaxon\CallableClass` a été déplacée dans un autre namespace.

Dans la version 3
```php
class HelloWorld extends \Jaxon\CallableClass
{
}
```

Dans la version 4
```php
class HelloWorld extends \Jaxon\App\CallableClass
{
}
```

## Le namespace pour les fonctions globales

Pour éviter d'éventuels conflits avec d'autres librairies, les fonctions globales, `jaxon()`, `pm()`, `rq()` et `jq()`, ont toutes été déplacées vers le namespace `Jaxon\`.

Dans la version 3
```php
$jaxon = jaxon();
```

Dans la version 4
```php
$jaxon = \Jaxon\jaxon();
```

Ou bien
```php
use function Jaxon\jaxon;

$jaxon = jaxon();
```

## La création des objets `Response`

Le constructeur de la classe `Response` a été modifié, et prend maintenant en paramètres des objets fournis par le conteneur de dépendances.
Par conséquent, la création des objets `Response` se fait désormais avec une méthode fournie par la classe `Jaxon`.

Dans la version 3
```php
$response = new Response();
```

Dans la version 4
```php
use function Jaxon\jaxon;

$response = jaxon()->newResponse();
```

L'objet global `Response` reste toujours accessible à l'aide de l'appel `jaxon()->getResponse()`.

## L'upload de fichiers

La fonction d'upload de fichiers est maintenant fournie dans un package séparé, et désactivée par défaut.

Pour l'utiliser, il faut donc installer le package [`jaxon-php\jaxon-upload`](https://github.com/jaxon-php\jaxon-upload), et donner à l'option `core.upload.enabled` la valeur booléenne `true`.

Son usage par contre reste identique à la version 3.

## La création de plugins

De nouvelles interfaces ont été définies, pour décrire les fonctions des plugins.
Selon les fonctions qu'il fournit, un plugin Jaxon doit implémenter une ou plusieurs de ces interfaces.

Pour les plugins de requête, `CallableRegistryInterface` pour ceux qui enregistrent des `callables`, `RequestHandlerInterface` pour ceux qui traitent des requêtes Jaxon, et `CodeGeneratorInterface` pour ceux qui génèrent du code javascript ou CSS.

Pour les plugins de réponse, il y a une seule interface `ResponsePluginInterface`.

## Les annotations

Les [annotations](../../06.annotations/01.about/) sont optionnelles, et fournies dans le package [`jaxon-php\jaxon-annotations`](https://github.com/jaxon-php\jaxon-annotations).

Elles sont cependant recommandées, car lorsqu'elle sont utilisées dans les classes Jaxon, elles simplifient l'usage d'autres fonctions.

#### L'injection de dépendance

L'annotation `@di` définit des objets à injecter dans les classes Jaxon, soit à leur instanciation, soit à l'appel de leurs fonctions.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    // L'attribut $firstService sera automatiquement défini à partir du conteneur
    // de dépendances, à chaque appel à cette classe.
    /**
     * @di
     * @var FirstService
     */
    protected $firstService;

    /**
     * @var SecondService
     */
    protected $secondService;

    // L'attribut $secondService sera automatiquement défini à partir du conteneur
    // de dépendances, mais uniquement à chaque appel à cette méthode.
    /**
     * @di $secondService
     */
    public function doThat()
    {
        // Call the services
        $this->firstService->doSomething();
        $this->secondService->doSomethingElse();

        return $this->response;
    }
}
```

#### Les data bags

L'annotation `@databag` permet de définir des data bags, qui sont des données stockées sur le client et disponibles à la demande dans les classes Jaxon.

```php
// Le data bag first_bag sera accessible dans toutes les méthodes de cette classe.
/**
 * @databag first_bag
 */
class HelloWorld extends \Jaxon\App\CallableClass
{
    // Le data bag second_bag sera disponible uniquement dans cette méthode.
    /**
     * @databag second_bag
     */
    public function doThat()
    {
        // Lire ou écrire des données dans les data bags.
        $this->bag('first_bag')->set('first_value', $firstValue);
        $secondValue = $this->bag('second_bag')->get('second_value');

        return $this->response;
    }
}
```

#### L'upload de fichiers

L'annotation `@upload` permet de télécharger des fichiers dans une méthode d'une classe Jaxon.

```php
class HelloWorld extends \Jaxon\App\CallableClass
{
    // L'appel à cette méthode télécharge les fichiers dans le champ HTML input avec l'id field_id.
    /**
     * @upload field_id
     */
    public function doThat()
    {
        // Récupérer les fichiers téléchargés.
        $uploadedFiles = $this->files();

        return $this->response;
    }
}
```
