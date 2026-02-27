<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Prefixes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RedExplosion\Sqids\Contracts\Prefix;

class ConsonantPrefix implements Prefix
{
    /**
     * Use the first 3 consonants as the model prefix.
     *
     * @param  class-string<Model>  $model
     */
    public function prefix(string $model): string
    {
        $classBasename = class_basename($model);

        $prefix = str_replace(search: ['a', 'e', 'i', 'o', 'u'], replace: '', subject: $classBasename);

        $prefix = rtrim(mb_strimwidth(string: $prefix, start: 0, width: 3, encoding: 'UTF-8'));

        return Str::lower($prefix);
    }
}
