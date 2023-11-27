<p align="center"><img width="400" src="./art/logo.svg" alt="Laravel Sqids Logo"></p>

# Laravel Sqids

[![Latest Version on Packagist](https://img.shields.io/packagist/v/red-explosion/laravel-sqids.svg?style=flat-square)](https://packagist.org/packages/red-explosion/laravel-sqids)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/red-explosion/laravel-sqids/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/red-explosion/laravel-sqids/actions/workflows/tests.yml?query=branch:main)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/red-explosion/laravel-sqids/coding-standards.yml?label=code%20style&style=flat-square)](https://github.com/red-explosion/laravel-sqids/actions/workflows/coding-standards.yml?query=branch:main)
[![Total Downloads](https://img.shields.io/packagist/dt/red-explosion/laravel-sqids.svg?style=flat-square)](https://packagist.org/packages/red-explosion/laravel-sqids)

Laravel Sqids (pronounced "squids") allows you to easily generate Stripe/YouTube looking IDs for your Laravel models.
These IDs are short and are guaranteed to be Collision free.

For more information of Sqids, we recommend checking out the official Sqids (formerly Hashids) webiste: [https://sqids.org](https://sqids.org).

## Installation

To get started, install Laravel Sqids using Composer:

```shell
composer require red-explosion/laravel-sqids
```

NExt, you should publish the Sqids configuration file using the `vendor:publish` artisan command. The `sqids`
configuration file will be placed in your applications `config` directory:

```shell
php artisan vendor:publish --provider="RedExplosion\Sqids\SqidsServiceProvider"
```

## Usage

### Using Sqids

To begin using Laravel Sqids, add the `RedExplosion\Sqids\HasSqids` trait to your model:

```php
use RedExplosion\Sqids\HasSqids;

class User exted Authenticatable
{
    use HasSqids;
}
```

You will be able able to access the Sqid for the model, by calling the `sqid` attribute:

```php
$user = User::first();

$sqid = $user->sqid; // use_A3EyoEb2TO
```

If you would like to set a custom prefix for the model, you can add a `$sqidPrefix` property to your model like so:

```php
use RedExplosion\Sqids\HasSqids;

class User exted Authenticatable
{
    use HasSqids;
    
    protected string $sqidPrefix = 'usr';
}

$user = User::first();
$sqid = $user->sqid; // usr_A3EyoEb2TO
```

### Builder Mixins

Laravel Sqids provides a number of Builder mixins to make working with Sqids seamless.

### Find by Sqid

To find a model by a given sqid, you can use the `findBySqid` method:

```php
$user = User::findBySqid('usr_A3EyoEb2TO');
```

If the model doesn't exist, `null` will be returned. However, if you would like to throw an exception, you can use
`findBySqidOrFail`:

```php
$user = User::findBySqidOrFail('usr_invalid');
```

### Where Sqid

...

### Where Sqid in

...

### Where Sqid not in

...

### Route model binding

Laravel Sqids supports route model binding out of the box. Simply create a route as you normally would and we'll take
care of the rest:

```php
// GET /users/usr_A3EyoEb2TO
Route::get('users/{user}', function (User $user) {
    return "Hello $user->name";
});
```

### Finding a model from a Sqid

One of the most powerful features of Laravel Sqids is being able to resolve a model instance from a given Sqid. This
could be incredibly powerful for searching models across your application. 

```php
use RedExplosion\Sqids\Model;

$model = Model::find('usr_A3EyoEb2TO');
```

When we run the following, `$user` will be an instance of the `User` model for the given Sqid. If no model could be
found, then `null` will be returned.

if you would like to throw an exception if a model can't be found, you can use the `findOrFail` method:

```php
use RedExplosion\Sqids\Model;

$model = Model::find('usr_A3EyoEb2TO');
```

> **Note**
> Please note this feature only works when using model Sqid prefixes.

## Testing

```shell
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to Ben Sherred via ben@redexplosion.co.uk. All security
vulnerabilities will be promptly addressed.

## Credits

- [Ben Sherred](https://github.com/bensherred)
- [All Contributors](../../contributors)

## License

Laravel Sqids is open-sourced software licensed under the [MIT license](LICENSE.md).
