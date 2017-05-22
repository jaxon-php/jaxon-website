---
title: Armada views
menu: Armada views
template: jaxon
---

The 3 views are located in the subdirectory `test` under the directory specified in the configuration.
They are rendered with the Twig template engine.

File `test/hello.html.twig`.

```php
{% verbatim %}
{% if isCaps == 0 or isCaps is empty %}
Hello World, by Twig!
{% else %}
HELLO WORLD, by Twig!
{% endif %}
{% endverbatim %}
```

File `test/credit.html.twig`.

```php
{% verbatim %}
This modal dialog is powered by {{ library }}!!
{% endverbatim %}
```

File `test/message.html.twig`.

```php
{% verbatim %}
{{ element }} {{ attr }} is now {{ value }}
{% endverbatim %}
```
