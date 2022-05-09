<?php declare(strict_types=1);

return [
    'displayErrorDetails' => LOCAL_ENV === 'development',
    'logErrors' => LOCAL_ENV != 'test' && php_sapi_name() != 'cli',
    'logErrorDetails' => true
];
