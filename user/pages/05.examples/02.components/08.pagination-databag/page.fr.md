---
title: Pagination et databag
menu: Pagination et databag
template: example
example:
    summary:
        - In this example the built-in pagination component in used with a databag.
---

When using the `Jaxon\App\PageDatabagTrait` trait, the current page number is saved in a user defined `databag`.
The component will show this page when it is re-rendered, instead of going back to the first page.

> Note: the `Refresh` button actually re-renders the component. But since the same page number is displayed, it seems like nothing has changed.
