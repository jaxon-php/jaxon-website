---
title: Les vues Armada
menu: Les vues Armada
template: jaxon
---

Les 3 vues se trouvent dans le sous-répertoire `test` du répertoire indiqué dans la configuration.
Elles sont affichées avec le moteur de template Twig.

Fichier `test/hello.html.twig`.

```php
{% verbatim %}
{% if isCaps == 0 or isCaps is empty %}
Hello World, by Twig!
{% else %}
HELLO WORLD, by Twig!
{% endif %}
{% endverbatim %}
```

Fichier `test/credit.html.twig`.

```php
{% verbatim %}
This modal dialog is powered by {{ library }}!!
{% endverbatim %}
```

Fichier `test/message.html.twig`.

```php
{% verbatim %}
{{ element }} {{ attr }} is now {{ value }}
{% endverbatim %}
```
