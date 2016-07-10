<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('start.php')
    ->in('${contrib.wsp.root}/jaxon-core/src')
;

return new Sami($iterator);
