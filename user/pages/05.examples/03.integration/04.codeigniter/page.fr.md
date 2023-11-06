---
title: Le plugin CodeIgniter
menu: Le plugin CodeIgniter
template: jaxon
cache_enable: false
---

Cet exemple montre l'utilisation du [plugin Jaxon pour le framework CodeIgniter](https://github.com/jaxon-php/jaxon-codeigniter?target=_blank).

Le fichier de configuration, les classes et les vues [se trouvent ici](https://github.com/jaxon-php/jaxon-examples/tree/master/frameworks/codeigniter?target=_blank).

#### Comment ça marche

Installer et configurer le plugin jaxon pour CodeIgniter, en suivant la procédure décrite dans la [documentation du plugin](https://github.com/jaxon-php/jaxon-codeigniter?target=_blank).

Dans le contrôleur de l'application, insérer le code généré par Jaxon dans la page.

```php
class Demo extends CI_Controller
{
    public function index()
    {
        // Load the Jaxon library
        $this->load->library('jaxon');

        // Register the Jaxon classes
        $this->jaxon->register();
        $this->load->view('index', array(
            'JaxonCss' => $this->jaxon->css(),
            'JaxonJs' => $this->jaxon->js(),
            'JaxonScript' => $this->jaxon->script()
        ));
    }
}
```
