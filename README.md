Jaxon Website
=============

The website of the Jaxon library, powered by the [Grav CMS](https://www.getgrav.org).

#### Installation

1. Install the Grav CMS

> composer create-project getgrav/grav web

2. Install the Grav plugins

> ./bin/gpm install piwik
> ./bin/gpm install langswitcher
> ./bin/gpm install blog-injector
> ./bin/gpm install jscomments
> ./bin/gpm install ganalytics


3. Install the website files

> Copy the `{wsp}/themes/habitat` dir to `{web}/user/themes`.

> Copy the `{wsp}/themes/habitat/assets` dir to `{web}/assets`.

> Copy the content of the `{wsp}/config` dir to `{web}/user/config`.

> Copy the content of the `{wsp}/pages` dir to `{web}/user/pages`.

4. Configure the web server to serve website root at `{web}`
