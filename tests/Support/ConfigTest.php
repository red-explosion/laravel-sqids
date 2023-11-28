<?php

declare(strict_types=1);

use RedExplosion\Sqids\Support\Config;

it('can get the alphabet', function (): void {
    expect(Config::alphabet())->toBe('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');

    config()->set('sqids.alphabet', 'abc');

    expect(Config::alphabet())->toBe('abc');

    config()->set('sqids.alphabet', 1);

    expect(Config::alphabet())->toBe('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
});

it('can get the min length', function (): void {
    expect(Config::minLength())->toBe(10);

    config()->set('sqids.min_length', 3);

    expect(Config::minLength())->toBe(3);

    config()->set('sqids.min_length', '4');

    expect(Config::minLength())->toBe(10);
});

it('can get the blacklist', function (): void {
    expect(Config::blacklist())->toBeArray()->toBeEmpty();

    config()->set('sqids.blacklist', ['foo']);

    expect(Config::blacklist())->toBeArray()->toBe(['foo']);

    config()->set('sqids.blacklist', 'foo');

    expect(Config::blacklist())->toBeArray()->toBeEmpty();
});

it('can get the separator', function (): void {
    expect(Config::separator())->toBe('_');

    config()->set('sqids.separator', '-');

    expect(Config::separator())->toBe('-');

    config()->set('sqids.separator', 1);

    expect(Config::separator())->toBe('_');
});

it('can get the prefix length', function (): void {
    expect(Config::prefixLength())->toBe(3);

    config()->set('sqids.prefix.length', 4);

    expect(Config::prefixLength())->toBe(4);

    config()->set('sqids.prefix.length', '1');

    expect(Config::prefixLength())->toBe(3);
});

it('can get the prefix case', function (): void {
    expect(Config::prefixCase())->toBe('lower');

    config()->set('sqids.prefix.case', 'upper');

    expect(Config::prefixCase())->toBe('upper');

    config()->set('sqids.prefix.case', 4);

    expect(Config::prefixCase())->toBe('lower');
});
