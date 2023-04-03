# Login your Users with a magic link or token

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yumbnl/laravel-magic-login.svg?style=flat-square)](https://packagist.org/packages/yumbnl/laravel-magic-login)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/yumbnl/laravel-magic-login/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/yumbnl/laravel-magic-login/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/yumbnl/laravel-magic-login/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/yumbnl/laravel-magic-login/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/yumbnl/laravel-magic-login.svg?style=flat-square)](https://packagist.org/packages/yumbnl/laravel-magic-login)

This package is still in development. It will take care of sending a temp login link / code upon request, to facilitate a passwordless login method. This is my first public package, so I'm sure there's plenty to improve upon!

## Installation

You can install the package via composer:

```bash
composer require yumbnl/laravel-magic-login
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-magic-login-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-magic-login-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-magic-login-views"
```

## Usage

Just install en add these to your routes files:

```php
// In your web routes, using the guest middleware
Route::MagicLoginWeb();

// In your api routes
Route::MagicLoginApi();
```

Both route macro's accept a string to change the base url for these routes. 

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [SanderGo](https://github.com/SanderGo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
