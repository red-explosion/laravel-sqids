<?php

declare(strict_types=1);

namespace RedExplosion\Sqids\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Prefix
{
    /**
     * @param  class-string<Model>  $model
     * @return string
     */
    public function prefix(string $model): string;
}
