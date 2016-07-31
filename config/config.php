<?php

return [
    'doctrine' => [
        'driver' => [
            'orm_vcms' => [
                'drivers' => [
                    'BlazonCms\OAuth2\Entity' => 'vcms',
                ],
            ],
            'vcms' => [
                'paths' => [__DIR__ . '/../src/Entity'],
            ],
        ],
    ],
];
