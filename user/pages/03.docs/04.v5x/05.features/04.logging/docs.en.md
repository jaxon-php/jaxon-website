---
title: Logs management
menu: Logging
template: jaxon
---

Jaxon does not implement a logging function, but supports the `PSR 3` standard, making it possible to use third-party libraries.

An instance of a logger must therefore be passed to the library when the application bootstraps, before it can log messages.

```php
use Psr\Log\LoggerInterface;

/** @var LoggerInterface $logger */
jaxon()->di()->setLogger($logger)
```

Messages can then be written to the logs with this call.

```php
jaxon()->logger()->debug('This is a message');
```

Component classes also provide a `logger()` method.

```php
class Component extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        $this->logger()->debug('This is a message');
    }
}
```
