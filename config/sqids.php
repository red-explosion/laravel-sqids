<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Shuffle Key
    |--------------------------------------------------------------------------
    |
    | This option is used to control the "shuffle key" for your Sqids. This
    | ensures that your Sqids are unique to your application. Changing
    | this value will result in all Sqids having a new value.
    |
    */

    'shuffle_key' => env('APP_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Alphabet
    |--------------------------------------------------------------------------
    |
    | This option controls the default "alphabet" used for generating Sqids.
    | The characters and numbers listed below will be included. You must
    | have at least 3 unique characters or numbers.
    |
    */

    'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',

    /*
    |--------------------------------------------------------------------------
    | Length
    |--------------------------------------------------------------------------
    |
    | This option controls the "minimum length" of the generated Sqid
    | excluding the prefix and separator. This value must be greater
    | than 0.
    |
    */

    'min_length' => 10,

    /*
    |--------------------------------------------------------------------------
    | Blacklist
    |--------------------------------------------------------------------------
    |
    | This option allows you to "blacklist" certain words that shouldn't be
    | included in the generated Sqids.
    |
    */

    'blacklist' => [],

    /*
    |--------------------------------------------------------------------------
    | Separator
    |--------------------------------------------------------------------------
    |
    | This option controls the "separator" between the prefix and the
    | generated Sqid.
    |
    */

    'separator' => '_',

    /*
    |--------------------------------------------------------------------------
    | Prefix Class
    |--------------------------------------------------------------------------
    |
    | This option controls the class that should be used for generating the
    | Sqid prefix. You can use any class that implements the following
    | contract: \RedExplosion\Sqids\Contracts\Prefix.
    |
    */

    'prefix_class' => RedExplosion\Sqids\Prefixes\ConsonantPrefix::class,

];
