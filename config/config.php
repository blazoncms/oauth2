<?php

return [
    'doctrine' => [
        'driver' => [
            'orm_blazon_cms' => [
                'drivers' => [
                    'BlazonCms\OAuth2\Entity' => 'bcms',
                ],
            ],
            'bcms' => [
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
        ],
    ],
];
