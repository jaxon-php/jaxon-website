---
title: L'autoloading
menu: L'autoloading
template: jaxon
---

Lorsque la librairie Jaxon traite un requête vers une classe, elle doit en créer une instance pour pouvoir exécuter la méthode appelée.
Elle doit par conséquent être capable de localiser toutes les classes enregistrées.

Pour le développeur qui le souhaite, la librairie Jaxon peut gérer l'autoloading pour toutes les classes qu'elle appelle.

#### Autoloading d'une classe

Lors de l'enregistrement d'une classe, l'option `include` permet d'indiquer le chemin du fichier dans lequel la classe est définie.

```php
$jaxon->register(Jaxon::CALLABLE_CLASS, HelloWorld::class, ['include' => '/path/to/dir/HelloWorld.php']);
```

Ce fichier sera inclus dans l'application uniquement si une méthode de la classe est appelée.

#### Autoloading d'un répertoire

Lors de l'enregistrement d'un répertoire sans namespace, l'option `autoload` permet d'activer l'autoloading.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['autoload' => true]);
```

Dans ce cas, Jaxon va parcourir le répertoire et enregistrer chaque classe trouvée avec le fichier correspondant, avec l'option `include`.

#### Autoloading d'un namespace

Lors de l'enregistrement d'un répertoire avec namespace, l'option `autoload` permet également d'activer l'autoloading.

```php
$jaxon->register(Jaxon::CALLABLE_DIR, '/the/class/dir', ['namespace' => 'App\Jaxon', 'autoload' => true]);
```

Dans ce cas, Jaxon va ajouter le répertoire dans le système d'autoloading de Composer.
