<?php declare(strict_types=1);

use Map\Spillebord\Spillebord;

// Set project root
const PROJECT_ROOT = __DIR__;

// Load autoloader
if (file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    require $composer;
} else {
    header(header: "HTTP/1.1 500 Internal Server Error");
    $data = require __DIR__ . '/resources/templates/static/system/errors/autoloader.php';
    exit($data);
}

// Load base environment settings
if (file_exists($baseEnvironment = __DIR__ . '/.env.php')) require $baseEnvironment;

// Set local environment
define("LOCAL_ENV", $_ENV['local.environment'] ?? 'production');

// Load local environment configurations
if (file_exists($localEnvironment = __DIR__ . '/.env.' . LOCAL_ENV . '.php')) require $localEnvironment;

// Configure error reporting
switch (LOCAL_ENV) {
    case 'development':
        error_reporting(error_level: E_ALL);
        ini_set(option: 'display_errors', value: '1');
        break;
    default:
        error_reporting(error_level: -1);
        ini_set(option: 'display_errors', value: '0');
        break;
}

// Set sane timezone for backend
date_default_timezone_set(timezoneId: 'UTC');

// Start application
$spillebord = new Spillebord();
$spillebord->run();
