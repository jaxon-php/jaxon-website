---
title: Les confirmations
menu: Les confirmations
template: example
example:
    summary:
        - Cet exemple montre l'utilisation de la fonction `confirm` et la commande `confirm` pour exécuter des actions conditionnelles.
---

When applied to a function call generated with a `call factory` (see the HTML template), the `confirm` function will ask the provided question and make the call only if the user confirms the question.

The `confirm` command in the `Response` object (see the `HelloWorld` class) will also ask a question, and execute the commands defined in the provided closure only if the user confirms that question.
The commands processing is halted while waiting for the user confirmation, and resumes after.
So in this example, the text color is changed only after the user answers to the second question.
