---
title: Les sessions
menu: Les sessions
template: jaxon
---

Jaxon fournit une API simple pour la gestion des sessions.

#### L'implémentation

L'implémentation actuelle des sessions dans Jaxon utilise les fonctions de session de PHP.

#### L'utilisation et l'API

L'appel à `jaxon()->session()` renvoie le gestionnaire de session.

```php
    $sessionId = jaxon()->session()->getId();
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
