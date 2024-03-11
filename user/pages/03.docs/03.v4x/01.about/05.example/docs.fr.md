---
title: Un exemple simple
menu: Un exemple simple
template: jaxon
---

Ceci est un exemple simple et fonctionnel, à la faxon de Xajax, qui montre toutes les étapes du fonctionnement de Jaxon.

```php
<?php
// 0. Jaxon est installé avec Composer. Définir l'autoloading.
require('./vendor/autoload.php');

use Jaxon\Jaxon;
use function Jaxon\jaxon;

// 1. Définir vos fonctions et classes.
function hello_world($isCaps)
{
    // Créer et utiliser une réponse Jaxon.
    $response = jaxon()->newResponse();
    $text = ($isCaps) ? 'HELLO WORLD!' : 'Hello World!';
    $response->assign('div1', 'innerHTML', $text);
    return $response;
}

// 2. Initialiser et configurer la librairie.
$jaxon = jaxon();

// 3. Enregistrer vos fonctions et classes.
$jaxon->register(Jaxon::CALLABLE_FUNCTION, "hello_world");

// 4. Traiter la requête.
if($jaxon->canProcessRequest())
{
    // Cette fonction va renvoyer la réponse et sortir.
    $jaxon->processRequest();
}

// 5. Insérer les codes Jaxon dans votre page HTML.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Jaxon Examples</title>
</head>
<body>
    <div id="div1">&nbsp;</div>
    <input type="button" value="Say Hello" onclick="jaxon_hello_world(true)" />
</body>
<!-- Jaxon CSS -->
<?php echo $jaxon->getCss(), "\n"; ?>
<!-- Jaxon JS -->
<?php echo $jaxon->getJs(), "\n"; ?>
<!-- Jaxon script -->
<?php echo $jaxon->getScript(), "\n"; ?>
</html>
```
