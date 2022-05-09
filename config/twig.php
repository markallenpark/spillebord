<?php declare(strict_types=1);

return [
    'paths' => [
        PROJECT_ROOT . '/resources/templates',
    ],
    'options' => [
        'cache' => (LOCAL_ENV == 'production') ? PROJECT_ROOT . '/temp/cache' : false,
    ]
];
