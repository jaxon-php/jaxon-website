---
title: Confirmations
menu: Confirmations
template: example
example:
    summary:
        - This example demonstrates the use of the `confirm` function and `confirm` command to execute conditional actions.
---

When applied to a function call generated with a `call factory` (see the HTML template), the `confirm` function will ask the provided question and make the call only if the user confirms the question.

The `confirm` command in the `Response` object (see the `setColor()` method in the `HelloWorld` class) will also ask a question, and execute the commands defined in the provided closure only if the user confirms that question.
The commands processing is halted while waiting for the user confirmation, and resumes after.
So in this example, the text color is changed only after the user answers to the second question.
