Jaxon Website
=============

The website of the [Jaxon library](https://www.jaxon-php.org), powered by the [Grav CMS](https://www.getgrav.org).

#### Installation

1. Clone this repository

2. Install the Grav CMS

> composer install

> ./bin/grav install

3. Install the Grav plugins

> ./bin/gpm install langswitcher

> ./bin/gpm install pagination

> ./bin/gpm install taxonomylist

> ./bin/gpm install archives

> ./bin/gpm install comments

4. Configure a virtual host on the web server

The `index.php` and the static files are moved to the `public` subdir.
Run the `update.sh` script to copy the static files, and configure the web server to give access to the `images` and `assets` dirs.
