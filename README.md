# Laravel Sqids

[![Latest Version on Packagist](https://img.shields.io/packagist/v/red-explosion/laravel-sqids.svg?style=flat-square)](https://packagist.org/packages/red-explosion/laravel-sqids)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/red-explosion/laravel-sqids/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/red-explosion/laravel-sqids/actions/workflows/tests.yaml?query=branch:main)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/red-explosion/laravel-sqids/coding-standards.yml?label=code%20style&style=flat-square)](https://github.com/red-explosion/laravel-sqids/actions/workflows/coding-standards.yml?query=branch:main)
[![Total Downloads](https://img.shields.io/packagist/dt/red-explosion/laravel-sqids.svg?style=flat-square)](https://packagist.org/packages/red-explosion/laravel-sqids)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require red-explosion/laravel-sqids
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="sqids-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="sqids-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="sqids-views"
```

## Usage

```php
$variable = new RedExplosion\Sqids();
echo $variable->echoPhrase('Hello, Red Explosion!');
```

## Testing

```bash
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

- [Ben Sherred](https://github.com/AUTHOR_USERNAME)
- [All Contributors](../../contributors)

## License

Laravel Sqids is open-sourced software licensed under the [MIT license](LICENSE.md).
