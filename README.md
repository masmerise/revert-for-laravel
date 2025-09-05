<p align="center"><img src="https://github.com/masmerise/laravel-revert/raw/master/art/banner.png" alt="Laravel Revert Banner" width="480" height="480"></p>

# Revert Laravel installations to the original v5 skeleton

[![Latest Version on Packagist](https://img.shields.io/packagist/v/masmerise/laravel-revert.svg?style=flat-square)](https://packagist.org/packages/masmerise/laravel-revert)
[![Total Downloads](https://img.shields.io/packagist/dt/masmerise/laravel-revert.svg?style=flat-square)](https://packagist.org/packages/masmerise/laravel-revert)

> [!WARNING]
> This package is supposed to be used *right after* having installed a **fresh** Laravel project using `laravel new`. 
> We are **not** responsible for any progress lost if you fail to follow this instruction.

## Why does this package exist?

This package aims to restore the former **5.0** structure with both the `Console` and `Http` kernels as this provides much more
flexibility compared to the new `ApplicationBuilder` class that comes with a lot of assumptions out of the box.

Laravel's new project structure simplified things a lot. However, this simplification comes at a trade-off.
Developers that are already well-versed in Laravel's ecosystem probably have no need for such a simplification because
the internals of the framework are like second nature to them.

As such, the main goal of this package is getting rid of `ApplicationBuilder` and keeping the other structural elements intact.

## Overview

These are the changes that'll be carried out in order to achieve the primary goal of this package,
which is the elimination of the new `ApplicationBuilder`:

1. `App\Console\Kernel` will be restored.
1. `App\Http\Kernel` will be restored.
1. `App\Exceptions\Handler` will be restored.
1. `App\Providers\RouteServiceProvider` will be restored.
1. The previous `boostrap/app.php` will be restored.
1. The `providers` key will be added back to `config/app.php`.
1. `bootstrap/providers.php` will be reconciled with the `providers` key in `config/app.php`.
1. `bootstrap/providers.php` will be removed.

> [!NOTE]
> If you need other previously available files such as `EventServiceProvider`,
> add these yourself. This package embraces the lean nature of the new structure except the `ApplicationBuilder`.

## Installation

You can install the package via [composer](https://getcomposer.org):

```bash
composer require --dev masmerise/laravel-revert
```

## Usage

```bash
php artisan revert
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email support@muhammedsari.me instead of using the issue tracker.

## Credits

- [Muhammed Sari](https://github.com/masmerise)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
