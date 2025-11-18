---
title: Les sessions
menu: Les sessions
template: jaxon
---

Armada fournit une API simple pour la gestion des sessions.

#### L'implémentation

L'implémentation actuelle des sessions dans Armada utilise le package [aura/session](https://packagist.org/packages/aura/session).
Cependant, ce package pouvant être changé, il est déconseillé d'utiliser directement ses fonctions.

#### La configuration

Les options de configuration des sessions se trouvent dans la section `app.sessions` du fichier de configuration.

L'option `app.sessions.driver` indique comment sont stockées les données de sessions.
Actuellement, elle accepte une seule valeur, `cookies`, qui est aussi sa valeur par défaut.

#### L'utilisation et l'API

Dans une classe d'une application Armada, la méthode `session()` renvoie le gestionnaire de session.

```php
    $sessionId = $this->session()->getId();
```

Les méthodes suivantes sont disponibles.

- Renvoie l'id de session.

```php
    public function getId()
```

- Génère un nouvel id de session.

```php
    public function newId($bDeleteData = false)
```

- Enregistre des données dans la session.

```php
    public function set($sKey, $xValue)
```

- Enregistre des données dans la session, qui seront disponibles seulement jusqu'à la prochaine requête.

```php
    public function flash($sKey, $xValue)
```

- Vérifie si une clé existe dans la session.

```php
    public function has($sKey)
```

- Retrouve des données dans la session.

```php
    public function get($sKey, $xDefault = null)
```

- Renvoie toutes les données de la session.

```php
    public function all()
```

- Supprime une clé de la session et ses données.

```php
    public function delete($sKey)
```

- Supprime toutes les données de la session.

```php
    public function clear()
```

- Supprime la session et toutes ses données.

```php
    public function destroy()
```
