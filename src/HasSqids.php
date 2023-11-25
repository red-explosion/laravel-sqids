<?php

declare(strict_types=1);

namespace RedExplosion\Sqids;

trait HasSqids
{
    public function getSqidAttribute(): ?string
    {
        return Sqids::forModel(model: $this);
    }
}
