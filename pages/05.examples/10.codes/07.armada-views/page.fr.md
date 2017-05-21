---
title: Les vues Armada
menu: Les vues Armada
template: jaxon
---

Les 3 vues se trouvent dans le sous-répertoire `test` du répertoire indiqué dans la configuration.
Elles sont affichées avec le moteur de template Twig.

Fichier `test/hello.html.twig`.

```php
{% if isCaps == 0 or isCaps is empty %}
Hello World, by Twig!
{% else %}
HELLO WORLD, by Twig!
{% endif %}
```

Fichier `test/credit.html.twig`.

```php
This modal dialog is powered by {{ library }}!!
```

Fichier `test/message.html.twig`.

```php
{{ element }} {{ attr }} is now {{ value }}
```
