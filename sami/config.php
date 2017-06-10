<?php

use Sami\Sami;
use Sami\RemoteRepository\GitHubRemoteRepository;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->exclude('start.php')
    ->in('${contrib.wsp.root}/jaxon-core/src')
    ->in('${contrib.wsp.root}/jaxon-sentry/src')
    ->in('${contrib.wsp.root}/jaxon-armada/src')
;

return new Sami($iterator);
