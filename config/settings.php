<?php

return [
    'settings' => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => false,
        'atlas' => [
            // DataSource generate script (generate-data-source в composer.json file)
            // Working for `pdo` connect only, need renamed
            'pdo' => [
                sprintf('mysql:dbname=%s;host=%s', getenv('MYSQL_DATABASE'), getenv('MYSQL_HOST')),
                getenv('MYSQL_USER'),
                getenv('MYSQL_USER'),
            ],
            'secondary' => [
                sprintf(
                    'mysql:dbname=%s;host=%s', 
                    getenv('SECONDARY_MYSQL_DATABASE'), 
                    getenv('SECONDARY_MYSQL_HOST')
                ),
                getenv('SECONDARY_MYSQL_USER'),
                getenv('SECONDARY_MYSQL_USER'),
            ],
            'namespace' => 'DataSource',
            'directory' => dirname(__DIR__) . '/src/classes/DataSource',
        ]
    ]
];
