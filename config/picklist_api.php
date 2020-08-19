<?php

return [
    'route' => [
        'prefix' => [
            'api' => env('PICCKLIST_ROUTE_PREFIX_API', 'api/picklist'),
        ],
    ],
    'auth' => [
        'api' => '',
    ],
];
