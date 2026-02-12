---
title: 'Develop Laravel Backpack addon in a monorepo'
date: '2026-02-12 07:30'
media:
    images:
        - backpack-desktop.png
taxonomy:
    category:
        - blog
    tag:
        - backpack
        - development
        - monorepo
---

When developing an addon for [Backpack](https://backpackforlaravel.com/), it is suggested to [code everything the package will need, before turning it into a package](https://backpackforlaravel.com/docs/7.x/add-ons-tutorial-using-the-addon-skeleton).
The package is then developed inside the Backpack install, and moved to its own repository only when being published.

In this post, an alternative setup is proposed, where the package repository is initially created with the minimun content.
Only the `composer.json` file is required. The addon can then be developed outside the Backpack install, for example is a directory side-by-side, and then published as-is, without any change to the namespace or files, either in the Backpack or in the addon.

The addon still needs to be initially created with the `packager:new` Artisan command provided by the `jeroen-g/laravel-packager` package.
But right after running that command, the package files can be moved to its repository. The namespace and `composer.json` file can be adjusted at this moment.

#### The repositories

This setup requires three repositories.

The first one is a monorepo. It is the only repository where the changes will be commited.
We'll call it `backpack-sample-mono`.

The second repository will host the Backpack application. Apart from the Laravel framework, no other Composer package is required to be installed here.
It is a read-only repository, that we'll call `backpack-sample-app`.

The third repository will host the Backpack addon. All other Composer packages the addon depends on must be installed here.
It is a read-only repository, that we'll call `backpack-sample-addon`.

While the number on Backpack addons that can be added in the same monorepo is unrestricted, by default there can be only one Laravel or Backpack app.
The reason is that the repositories in the monorepo need to have distinct namespaces, and by default all Backpack applications use the same `App` namespace.

#### Configure the monorepo

We'll now use the `git subtree` command and the [Contao Monorepo Tools](https://github.com/contao/monorepo-tools) package to configure our monorepo.

Let's start by cloning the repositories.
The read-only repositories are added in the monorepo with `git subtree`.

```bash
git clone git@github.com:sample-org/backpack-sample-mono.git
cd backpack-sample-mono
git subtree add --prefix backpack-sample-app git@github.com:sample-org/backpack-sample-app.git main --squash
git subtree add --prefix backpack-sample-addon git@github.com:sample-org/backpack-sample-addon.git main --squash
```

Now, the `backpack-sample-mono` repository has a copy of the `backpack-sample-app` and `backpack-sample-addon` contents in subdirs.
Provided that the `backpack-sample-app` and `backpack-sample-addon` repositories each have their own `composer.json` file, we are going to merge them into a single `composer.json` file in the monorepo.

Create a `monorepo.yml` file with the following content.

```yaml
# URL or absolute path to the remote GIT repository of the monorepo
monorepo_url: git@github.com:sample-org/backpack-sample-mono

# All branches that match this regular expression will be split by default
branch_filter: /^(main|develop|\d+\.\d+)$/

# List of all split projects
repositories:
    backpack-sample-app:
        # URL or absolute path to the remote GIT repository
        url: git@github.com:sample-org/backpack-sample-app.git
    backpack-sample-addon:
        # URL or absolute path to the remote GIT repository
        url: git@github.com:sample-org/backpack-sample-addon.git

# Optional additional composer settings for the root composer.json
composer:
    require-dev:
        contao/monorepo-tools: ^0.2
```

Then run the following commands.

```bash
composer init
composer require --dev contao/monorepo-tools
./vendor/bin/monorepo-tools composer-json
composer update
```

The `composer init` command asks some information about the project, and creates a basic `composer.json` file.
The `./vendor/bin/monorepo-tools composer-json` command merges the `composer.json` files, provided that all the packages which are required in many repositories have the same version.

Now that all the dependencies are installed, the last step is to load the monorepo `vendor` dir in the Backpack application.
To achieve that, we just symlink the Backpack `vendor` dir to the monorepo `vendor` dir.

```bash
cd backpack-sample-app
rm -rf vendor
ln -s ../vendor vendor
cd ..
```

The setup is now ready, and after the package service provider is registered in the Backpack application, it will now be able to load the addon exactly as if it was installed with Composer.

All the changes to any file in the project are initially commited to the monorepo.
The [Contao Monorepo Tools](https://github.com/contao/monorepo-tools) package provides a simple command to update the read-only repositories with the commits in the monorepo.

```bash
cd backpack-sample-mono
./vendor/bin/monorepo-tools split
```

With is setup, using a monorepo and the [Contao Monorepo Tools](https://github.com/contao/monorepo-tools) package, multiple addons can be developed side-by-side with a single Backpack install.
