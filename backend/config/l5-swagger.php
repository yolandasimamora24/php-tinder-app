<?php

return [

    'default' => 'default',

    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Tinder Clone API',
            ],

            'routes' => [
                'api' => 'api/documentation', // Swagger UI URL
                'docs' => 'api/docs',
                'oauth2_callback' => 'api/oauth2-callback',
            ],

            'paths' => [
                'annotations' => base_path('app'), // scan all app files
                'docs' => storage_path('api-docs'),
                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',
                'excludes' => [],
                'base' => env('APP_URL'),
            ],

            'proxy' => false,
            'operations_sort' => null,
            'validator_url' => null,
            'additional_config_url' => null,

            'securityDefinitions' => [
                'securitySchemes' => [],
            ],

            // 🔹 Must be inside each documentation block
            'generate_always' => true,
        ],
    ],

    // Defaults for new docs if created
    'defaults' => [
        'routes' => [
            'api' => 'api/documentation',
        ],
        'paths' => [
            'annotations' => base_path('app'),
            'docs' => storage_path('api-docs'),
            'docs_json' => 'api-docs.json',
            'docs_yaml' => 'api-docs.yaml',
            'excludes' => [],
            'base' => env('APP_URL'),
        ],
        'proxy' => false,
        'operations_sort' => null,
        'validator_url' => null,
        'additional_config_url' => null,
        'securityDefinitions' => [
            'securitySchemes' => [],
        ],
        'generate_always' => true, // also here for safety
    ],
];
