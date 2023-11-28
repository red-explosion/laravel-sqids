<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Prefixes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RedExplosion\Sqids\Contracts\Prefix;

class ConstantPrefix implements Prefix
{
    /**
     * Use the first 3 constants as the model prefix.
     *
     * @param  class-string<Model>  $model
     * @return string
     */
    public function prefix(string $model): string
    {
        $classBasename = class_basename(class: $model);

        $prefix = str_replace(search: ['a', 'e', 'i', 'o', 'u'], replace: '', subject: $classBasename);

        $prefix = rtrim(mb_strimwidth(string: $prefix, start: 0, width: 3, encoding: 'UTF-8'));

        return Str::lower(value: $prefix);
    }
}
