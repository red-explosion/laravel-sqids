<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Length
    |--------------------------------------------------------------------------
    |
    | This option controls the "minimum length" of the generated sqid
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
    | THis option allows you to "blacklist" certain words that shouldn't be
    | included in the generated sqids.
    |
    */

    'blacklist' => [],

    /*
    |--------------------------------------------------------------------------
    | Separator
    |--------------------------------------------------------------------------
    |
    | This option controls the "separator" between the prefix and the
    | generatedsqid.
    |
    */

    'separator' => '_',

    /*
    |--------------------------------------------------------------------------
    | Prefix
    |--------------------------------------------------------------------------
    |
    | This option controls the sqid "prefix", You can control the length of
    | the prefix and the casing. By default, the prefix will be generated
    | based on the model name.
    |
    | Setting the prefix length to "0" will remove the prefix all together.
    |
    | Supported Casing: "lower", "upper", "camel", "snake", "kebab",
    |         "title", "studly"
    |
    */

    'prefix' => [
        'length' => 3,
        'case' => 'lower',
    ],

];
