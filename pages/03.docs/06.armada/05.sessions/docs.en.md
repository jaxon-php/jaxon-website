---
title: The sessions
menu: The sessions
template: jaxon
---

Armada provides a simple API for sessions management.

#### The implementation

The current session management implementation in Armada uses the [aura/session](https://packagist.org/packages/aura/session) package.
However, since this package can be changed, it is not recommended to make direct calls to its functions.

#### The configuration

The `app.sessions` section of the Armada configuration file contains the sessions configuration options.

The `app.sessions.driver` option indicates how the session data are stored.
It currently accepts only one value, `cookies`, which is also its default value.

#### The usage and the API

In a class of an Armada application, the `session()` method returns the session manager.

```php
    $sessionId = $this->session()->getId();
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
