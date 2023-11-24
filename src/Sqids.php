<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

trait Sqids
{
    public function getSqidAttribute(): ?string
    {
        $sqids = new \Sqids\Sqids();

        return $sqids->encode([$this->getKey()]);
    }
}
