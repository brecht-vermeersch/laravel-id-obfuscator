<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default IdObfuscator
    |--------------------------------------------------------------------------
    |
    | This option controls the default obfuscator that will be used by the
    | framework. You may set this to any of the connections defined in the
    | "connections" array below.
    |
    | Supported: "hashids", "optimus", "null"
    |
    */

    'default' => env('ID_OBFUSCATOR_DRIVER', 'null'),

    /*
    |--------------------------------------------------------------------------
    | IdObfuscator Connections
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the obfuscator connections that will be used
    | to encode or decode ids. Samples of each available type of connection are \
    | provided inside this array.
    |
    */

    'connections' => [

        'hashids' => [
            'driver' => 'hashids',
            'salt' => env('HASHIDS_SALT'),
            'minimumHashLength' => env('HASHIDS_MINIMUM_HASH_LENGTH'),
            'alphabet' => env('HASHIDS_ALPHABET')
        ],

        'optimus' => [
            'driver' => 'optimus',
            'prime' => env('OPTIMUS_PRIME'),
            'inverse' => env('OPTIMUS_INVERSE'),
            'random' => env('OPTIMUS_RANDOM')
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
