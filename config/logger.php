<?php declare(strict_types=1);

use Monolog\Logger;

return [
    'name' => 'spillebord',
    'path' => PROJECT_ROOT . '/temp/logs',
    'filename' => 'spillebord.log',
    'level' => (LOCAL_ENV == 'development') ? Logger::DEBUG : Logger::INFO,
    'filePermissions' => 0775,
];
