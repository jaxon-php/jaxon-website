---
title: The sessions
menu: The sessions
template: jaxon
---

Jaxon provides a simple API for session management.

#### The implementation

The current session management implementation in Jaxon uses the PHP session functions.

#### The usage and the API

A call to `jaxon()->session()` returns the session manager.

```php
    $sessionId = jaxon()->session()->getId();
```

The following methods are available.

- Get the current session id.

```php
    public function getId()
```

- Generate a new session id.

```php
    public function newId($bDeleteData = false)
```

- Save data in the session.

```php
    public function set($sKey, $xValue)
```

- Save data in the session, that will be available only until the next request.

```php
    public function flash($sKey, $xValue)
```

- Check if a session key exists.

```php
    public function has($sKey)
```

- Get data from the session.

```php
    public function get($sKey, $xDefault = null)
```

- Get all data in the session.

```php
    public function all()
```

- Delete a session key and its data.

```php
    public function delete($sKey)
```

- Delete all data in the session.

```php
    public function clear()
```

- Delete the session and all its data.

```php
    public function destroy()
```
