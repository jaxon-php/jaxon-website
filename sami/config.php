<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('start.php')
    ->in('/home/newshub/workspace/contrib/jaxon-core/src')
;

return new Sami($iterator);