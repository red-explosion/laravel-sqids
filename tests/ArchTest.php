<?php

declare(strict_types=1);

it('will not use debugging functions')
    ->expect(['dd', 'ddd', 'dump', 'var_dump', 'ray'])
    ->each->not->toBeUsed();
