Jaxon Website
=============

The website of the [Jaxon library](https://www.jaxon-php.org), powered by the [Grav CMS](https://www.getgrav.org).

## Installation

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
> ./bin/gpm install page_stats
> ./bin/gpm install recent_posts

4. Configure a virtual host on the web server

The `index.php` and the static files are moved to the `public` subdir.
Run the `update.sh` script to copy the static files, and configure the web server to give access to the `images` and `assets` dirs.

## Nginx config

This is a sample Nginx config for the website.

```
server {
    listen 80;
    server_name  jaxon-php.org;

    rewrite ^ https://www.jaxon-php.org$request_uri permanent;
}

server {
    listen 80;
    server_name  www.jaxon-php.org;

    access_log  /var/log/nginx/jaxon.access.log main;
    error_log   /var/log/nginx/jaxon.error.log debug;

    location / {
        proxy_pass http://unit_jaxon;
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }

    # Deny direct access to these files
    location ~* .*\.(log|xml|md|htm|shtml|shtm|json|yaml|yml|php|php2|php3|php4|php5|phar|phtml|pl|py|rb|cgi|twig|sh|bat|map|rar|zip|sql|bak|tmp|aspx|pub|pem|key|conf|backup)$ {
        return 403;
    }
    location ~* .*(\.well-known|\.aws|\.env|cgi-bin|phpinfo|\.sendgrid|\.circleci|\.c9|\.idea|\.travis|\.vite|\.docker|\.git|\.ssh|\.svn|\.s3|\.profile|\.remote|\.yarn|graphql).* {
        return 403;
    }
}
```
