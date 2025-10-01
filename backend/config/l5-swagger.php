<?php

return [

    'default' => 'default',

    'documentations' => [
        'default' => [
            'securityDefinitions' => [
                'securitySchemes' => [
                    'Bearer' => [
                        'type' => 'apiKey',
                        'description' => 'Enter token like: Bearer {token}',
                        'name' => 'Authorization',
                        'in' => 'header',
                    ],
                ],
            ],
            'api' => [
                'title' => 'Tinder Clone API',
            ],
    
            'routes' => [
                'api' => 'api/documentation',
                'docs' => 'api/docs',
                'oauth2_callback' => 'api/oauth2-callback',
            ],
    
            'paths' => [
                'annotations' => base_path('app'),
                'docs' => public_path('storage/api-docs'),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'excludes' => [],
                'base' => env('APP_URL'),
            ],
    
            'proxy' => false,
            'operations_sort' => null,
            'validator_url' => null,
            'additional_config_url' => null,
    
            'generate_always' => true,
        ],
    ],
    
    'defaults' => [
        'securityDefinitions' => [
            'securitySchemes' => [
                'Bearer' => [
                    'type' => 'apiKey',
                    'description' => 'Enter token like: Bearer {token}',
                    'name' => 'Authorization',
                    'in' => 'header',
                ],
            ],
        ],
    
        'routes' => [
            'api' => 'api/documentation',
            'docs' => 'api/docs',
            'oauth2_callback' => 'api/oauth2-callback',
        ],
    
        'paths' => [
            'annotations' => base_path('app'),
            'docs' => public_path('storage/api-docs'),
            'docs_json' => 'api-docs.json',
            'docs_yaml' => 'api-docs.yaml',
            'excludes' => [],
            'base' => env('APP_URL'),
        ],
    
        'proxy' => false,
        'operations_sort' => null,
        'validator_url' => null,
        'additional_config_url' => null,
    
        'generate_always' => true,
    ],
    
];
