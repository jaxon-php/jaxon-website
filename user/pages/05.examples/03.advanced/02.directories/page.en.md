---
title: Register Classes in directories
menu: Register directories
template: example
example:
    summary:
        - This example shows how to automatically register all the classes in a set of directories.
        - When classes registered from a directory are not namespaced, they all need to have different names, even if they are in different subdirs.
---

The `App` and `Ext` classes, without a namespace, are defined in two directories, which are exported to Javascript.
