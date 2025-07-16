<?php

/**
 * @package    Grav.Core
 *
 * @copyright  Copyright (c) 2015 - 2024 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav;

use Dotenv\Dotenv;

\define('GRAV_REQUEST_TIME', microtime(true));
\define('GRAV_PHP_MIN', '7.3.6');

// if (PHP_SAPI === 'cli-server') {
//     $symfony_server = stripos(getenv('_'), 'symfony') !== false || stripos($_SERVER['SERVER_SOFTWARE'] ?? '', 'symfony') !== false || stripos($_ENV['SERVER_SOFTWARE'] ?? '', 'symfony') !== false;

//     if (!isset($_SERVER['PHP_CLI_ROUTER']) && !$symfony_server) {
//         die("PHP webserver requires a router to run Grav, please use: <pre>php -S {$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']} system/router.php</pre>");
//     }
// }

$rootDir = dirname(__DIR__);
define('GRAV_ROOT', $rootDir);

// Ensure vendor libraries exist
$autoload = "$rootDir/vendor/autoload.php";
if (!is_file($autoload)) {
    die('Please run: <i>bin/grav install</i>');
}

// Register the auto-loader.
$loader = require $autoload;

// Set timezone to default, falls back to system if php.ini not set
date_default_timezone_set(@date_default_timezone_get());

// Set internal encoding.
@ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Load the .env file
$dotenv = Dotenv::createUnsafeImmutable($rootDir);
$dotenv->safeLoad();

use Grav\Common\Grav;
use RocketTheme\Toolbox\Event\Event;

// Get the Grav instance
$grav = Grav::instance(array('loader' => $loader));

// Process the page
try {
    $grav->process();
} catch (\Error|\Exception $e) {
    $grav->fireEvent('onFatalException', new Event(array('exception' => $e)));
    throw $e;
}
