<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image security system
    |--------------------------------------------------------------------------
    |
    | To prevent users from accessing images in formats you did not provide
    | to that specific user, each link contains a security code.
    | This code is generated using class specified as keyGenerator.
    |
    | We suggest against using the APP_KEY without hashing it first
    | to prevent it from leaking outside, since the hashing algorithm
    | is well known and could be used to reverse engineer the code.
    |
    | If extra security is required, I suggest writing custom keyGenerator.
    |
    */

    'security' => [
        'keyGenerator' => 'sha1',
        'masterKey' => hash('sha256', env('APP_KEY')),
    ],


    /*
    |--------------------------------------------------------------------------
    | Image cache system
    |--------------------------------------------------------------------------
    |
    | This is where processed images will be stored.
    | Large and fast storage is suggested since imaginator
    | will not delete old files.
    | If that is desired you could use a custom delete mechanism.
    |
    | Imaginator will use extra level of cache by providing a 1 year
    | cache-control headers, but this folder is still the main source of files.
    |
    */

    'cache' => storage_path('cache/images'),

    /*
    |--------------------------------------------------------------------------
    | Image provider subsystems
    |--------------------------------------------------------------------------
    |
    | Each image is defined by 2 variables: a provider and an instance
    | Here you should register your own providers.
    | You can specify an optional type, that your provider will accept,
    | if you dont want to make a type comparision in it.
    | Provider should return NULL if no image was found
    | or a string containing path to provided file
    |
    | If your provider require extra config, then put it as array
    |
    */

    'providers' => [
        [
            'filesystem',
            storage_path('data/images'),
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Entity provider subsystems
    |--------------------------------------------------------------------------
    |
    | Classes defined in this section will be used to map entities
    | into provider-instance pairs used in rest of the library.
    |
    | As always you can define multiple providers
    | and return null from providers that do not apply to specified entity
    |
    | Default provider moves this responsibility to entities in form of
    | ImageProvidingEntity interface and should fit most use cases.
    |
    */

    'entity_providers' => [
        'imageProvidingEntity',
    ],

    /*
    |--------------------------------------------------------------------------
    | Image processors subsystems
    |--------------------------------------------------------------------------
    |
    | Processors are used to convert images from one format to another.
    | Here you can add custom formats or transformation libraries.
    | By default we support jpg, and png conversions using Intervention library
    |
    */

    'processors' => [
        'jpg' => 'jpg',
        'png' => 'png',
    ],


    /*
    |--------------------------------------------------------------------------
    | Image formats subsystems
    |--------------------------------------------------------------------------
    |
    | Here you define formats that you would like to provide your users with.
    |
    | First level key defines your image source TYPE - the same value as with providers.
    | You can use '*' to define formats available for all types (not recommended)
    |
    | Second level key defines FORMAT that you are interested in.
    | Using numeric keys (or no keys) will allow you to include format groups.
    |
    | Type parameter is required, and defines processor to be used.
    | All other parameters are optional and depend on selected processor.
    |
    */

    'formats' => [
        '*' => [
            '800x600' => [
                'processor' => 'jpg',
                'quality' => 80,
                'width' => 800,
                'height' => 600,
            ],
        ],

        'squares' => [
            'small' => [
                'processor' => 'jpg',
                'quality' => 50,
                'width' => 100,
                'height' => 100,
            ],
            'big' => [
                'processor' => 'jpg',
                'quality' => 90,
                'width' => 1000,
                'height' => 1000,
            ],
        ],

        'avatars' => [
            'squares',
            'medium' => [
                'processor' => 'jpg',
                'quality' => 70,
                'width' => 500,
                'height' => 500,
            ]
        ],
    ],
];
