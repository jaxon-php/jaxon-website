---
title: Optimized processing
position: 2
read:
    text: Read more
    link: /docs/v3x/requests/autoloading.html
---

By default, all the classes registered with the Jaxon library are instanciated anytime a request is processed.

When classes are exported from a directory, the Jaxon library can be optimized to load only the class that was called.
Other classes can also be instanciated later, thus avoiding to create objects that will never be used.
