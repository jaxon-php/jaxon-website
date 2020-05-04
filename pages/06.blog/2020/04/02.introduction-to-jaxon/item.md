---
title: 'Introduction to Jaxon'
date: '04-05-2020 08:00'
media:
    images:
        - markus-spiske-unsplash.jpg
taxonomy:
    category:
        - blog
    tag:
        - php
        - javascript
        - ajax
---

The stable version 2.0.0 of the Jaxon library has just been released. It brings out new features, including the views and sessions management function, a jQuery-like API to update the page content, the Armada and Sentry packages that provide more advanced features and a common foundation for integration packages with PHP frameworks.

This article outlines the developments of the library from version 1 on, with a focus on the architecture of version 2 as well as the new features added. It's the first of a series of articles about Jaxon. The next ones, more technical in essence, will present the most important features of the library.

1. History

[Jaxon](https://www.jaxon-php.org) is a fork of the [Xajax PHP library](http://www.xajax-project.org) that brought a unique and original way to easily create Ajax web applications with PHP. It allows a web page to make direct Ajax calls to PHP classes that will in turn update its content as well as its layout, without reloading the entire page (server-side rendering). Creating an Ajax Web application becomes very easy with Xajax, for a Javascript call is enough to execute the most complex actions on the web page, these actions being programmed in PHP on the server.
Unfortunately, the development of the library was suspended in 2012, soon after the release of version 0.6, for reasons that remain unknown.

A new version of the library was first published on Github in February 2016, then renamed in March as Jaxon and published for the first time under that name. Soon after, in July 2016, version 1.0.0 was released. It took over the main features of Xajax, but with a completely re-written code, separating the library into one Javascript package and several PHP packages, using Composer for installation, as well as some plugins. At the end of December 2016, the first beta build of version 2 was released. 7 months, 117 commits and 28 releases later, it was finally released in a stable version 2.0.0.

2. What's new in Jaxon?

In version 1, the major change is the ability to register PHP classes in a directory with a single line of code, taking their namespaces into account. In addition, the library can be configured from a file, and the functions to generate the Ajax code that calls the PHP classes are enriched, especially with directories, namespaces, and pagination features.

The major changes in version 2 are the Armada and Sentry packages, the management of views and sessions feature, as well as the jQuery-PHP API. Unit tests have also been added to the library, although the coverage is still to be improved.

The [Armada and Sentry](https://www.jaxon-php.org/docs/armada/operation.html) packages provide a base class that the classes of applications inherit from, and provide them with many functions. They also offer a common API for managing views and sessions, which relies on functions provided by frameworks or other PHP libraries. The jQuery-PHP API provides functions inspired by the Javascript jQuery library to update the content of the application pages in PHP.

The most important advantage of Armada and Sentry is the ability to reuse the classes of a Jaxon application with different PHP frameworks.

3. Jaxon packages

The Jaxon library is composed of 4 main packages, and plugins that add functions or integrate it to PHP frameworks.

The main packages are:
- jaxon-core and jaxon-js, which respectively provide the PHP and Javascript functions.
- jaxon-sentry and jaxon-armada, which provide advanced functions, and a common platform for integration with PHP frameworks.

Integration packages simplify the use of Jaxon with the most common PHP frameworks. They come in the form of a plugin for the framework concerned, with functions to load the configuration of Jaxon from a file in the format defined by the framework, and load the Jaxon classes from predefined directory and namespace. They also provide an adapter that allows to use the Jaxon views and sessions management API with the functions provided by the framework.

A single integration package can be used in an application, depending on the framework used. For frameworks that are not yet supported, the jaxon-armada package must be used.

Integration packages currently exist for 6 PHP frameworks:
- Symfony: https://github.com/jaxon-php/jaxon-symfony
- Laravel: https://github.com/jaxon-php/jaxon-laravel
- Zend Framework: https://github.com/jaxon-php/jaxon-zend
- Cake PHP: https://github.com/jaxon-php/jaxon-cake
- CodeIgniter: https://github.com/jaxon-php/jaxon-codeigniter
- Yii: https://github.com/jaxon-php/jaxon-yii

The Armada and Sentry packages provide a unique view API, which can be used with different template engines. In a Jaxon application, views that use a given template engine are placed in a directory, which is then specified in the configuration with the engine id.

```php
    'app' => array(
        'views' => array(
            'users' => array(
                'directory' => '/path/to/users/views',
                'extension' => '.tpl',
                'renderer' => 'smarty',
            ),
        ),
    ),
```

The id is then used in Jaxon classes to display the templates with the chosen engine.

```php
    // Render the view at /path/to/users/views/path/to/view.tpl with Smarty
    $html = $this->view()->render('users::path/to/view');
```

The support for each template engine is implemented in a separate package, several of which can be used in the same application:
- Twig https://github.com/jaxon-php/jaxon-twig.
- Smarty https://github.com/jaxon-php/jaxon-smarty.
- Blade https://github.com/jaxon-php/jaxon-blade.
- Dwoo https://github.com/jaxon-php/jaxon-dwoo.
- Latte https://github.com/jaxon-php/jaxon-latte.
- RainTpl https://github.com/jaxon-php/jaxon-raintpl.

Finally, the jaxon-dialogs package provides a unique API that can be used with different Javascript libraries to display windows, confirmation dialogs, and notifications. As we are writing this article, 16 Javascript libraries are supported, and each user can add new ones.

4. Armada and Sentry

Armada and Sentry packages are the core of version 2. The Sentry package provides the classes and interfaces that implement or define all the library functions, whether it is for application class management, or for views and sessions management. However, the package is not intended to be used directly by developers. The Armada package, that depends on Sentry, will provide them with all these functionalities.

It is worth noting that integration packages to PHP frameworks also depend on Sentry packages. This allows to have common APIs for Jaxon applications, whether they use Armada or whether they are integrated into a PHP framework. In particular, a class of an application that uses these APIs can be reused without being modified with Armada as well as PHP frameworks.

This property is very interesting because it paves the way for the creation of complete application modules, with views and sessions functions, which can be compatible with several different PHP frameworks. That was not possible until today.
An example of such a module would be a user management application.

5. Application classes

The classes of a Jaxon Armada application can be located in several directories, each having a distinct namespace. All the directories are declared in the `app.classes` section of the configuration file.

The classes inherit from the Jaxon\Sentry\Armada class, which provides a large number of functions that are used to build the application.
- Updating the content and layout of the application pages. These are the functions that make it possible to manipulate the DOM (Document Object Model) of a webpage, i.e modify its content (HTML) or its layout (CSS).
- Creating Ajax requests to application classes. These functions generate the Javascript code necessary to call the PHP classes of the application directly from the web page, and to link this code to events in the elements of the page.
- Managing views and sessions.

All these functions are defined or implemented in the Sentry package, which serves as the common foundation to the Armada package as well as all the other PHP framework integration packages. Therefore, a class of an Armada application can be used with any supported PHP framework, without requiring any modification.

6. Future developments

They will be focused on three main points: enriching the library's ecosystem with more plugins, making it more reliable with more tests, and upgrading its Javascript library.

Regarding the first point, two new plugins are currently underway. The first is a plugin to display graphs on a web page with several Javascript libraries to choose from. It is drawn from the Laravel chart package (https://github.com/ConsoleTVs/Charts). The second is a complete user management module similar to Voyager (https://laravelvoyager.com) or LaraAdmin (http://laraadmin.com), but with much less functionalities. Based on Armada and Sentry, it will demonstrate the creation of cross-framework modules with Jaxon.

Currently, only a portion of the library code is covered by unit tests. The objective will consist of increasing the coverage of tests, and adding functional tests, so it is possible to validate the proper functioning of the library at the level of a webpage.

Finally, unlike PHP code, the Javascript code of the library did not change that much. It would be interesting to use one or more micro-frameworks (http://microjs.com) to implement some of its functions, with the objective of reducing its size and adding tests.
