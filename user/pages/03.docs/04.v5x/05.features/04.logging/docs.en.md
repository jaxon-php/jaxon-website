---
title: Logs management
menu: Logging
template: jaxon
---

Jaxon does not implement a logging function, but supports the `PSR 3` standard interface, making it possible to use third-party libraries.

An instance of a logger must therefore be passed to the library when the application bootstraps, before it can log messages.
Without this call, Jaxon by default uses the `Psr\Log\NullLogger` logger, thus all the logged messages are lost.

```php
use Psr\Log\LoggerInterface;

/** @var LoggerInterface $logger */
jaxon()->di()->setLogger($logger)
```

Messages are written to the logs with this call.

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

### The Logger facade

Starting from the `5.3.1` release, Jaxon integrates the [https://github.com/lagdo/facades](https://github.com/lagdo/facades) package.
This package provides a facade for logging, which the Jaxon library configures by default to use the logger defined in its container.

```php
use Lagdo\Facades\Logger;

class Component extends \Jaxon\App\FuncComponent
{
    public function doThat()
    {
        Logger::debug('This is a message');
    }
}
```

### Frontend logging

The Jaxon Javascript library can be configured to send its log messages to the PHP application on the server, which will write them to the logging system.
This feature is disabled by default, and must be explicitly enabled using a configuration option.

```php
jaxon()->setAppOption('options.logging.enabled', true);
```
Or
```php
    'app' => [
        'options' => [
            'logging' => [
                'enabled' => true
            ],
        ],
    ],
```

When this option is enabled, Jaxon exports a `Logger` [component](../../components/types.html) in Javascript, which will be called every time a message is written.
The `Logger` component simply forwards all the messages it receives to the logging system.
