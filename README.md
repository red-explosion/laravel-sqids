# package_name

[![Latest Version on Packagist](https://img.shields.io/packagist/v/red-explosion/package_slug.svg?style=flat-square)](https://packagist.org/packages/red-explosion/package_slug)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/red-explosion/package_slug/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/red-explosion/package_slug/actions/workflows/tests.yaml?query=branch:main)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/red-explosion/package_slug/coding-standards.yml?label=code%20style&style=flat-square)](https://github.com/red-explosion/package_slug/actions/workflows/coding-standards.yml?query=branch:main)
[![Total Downloads](https://img.shields.io/packagist/dt/red-explosion/package_slug.svg?style=flat-square)](https://packagist.org/packages/red-explosion/package_slug)
<!--delete-->
---
This repo can be used to scaffold a Red Explosion Laravel package. Follow these steps to get started:

1. Press the "Use this template" button at the top of this repo to create a new repo with the contents of this skeleton.
---
<!--/delete-->
This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require red-explosion/package_slug
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="skeleton-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="skeleton-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="skeleton-views"
```

## Usage

```php
$variable = new RedExplosion\Skeleton();
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

- [author_name](https://github.com/author_username)
- [All Contributors](../../contributors)

## License

package_name is open-sourced software licensed under the [MIT license](LICENSE.md).
