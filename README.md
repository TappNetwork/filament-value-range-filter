# Filament Value Range Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tapp/filament-value-range-filter.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-value-range-filter)
![GitHub Tests Action Status](https://github.com/TappNetwork/filament-value-range-filter/actions/workflows/run-tests.yml/badge.svg)
![Code Style Action Status](https://github.com/TappNetwork/filament-value-range-filter/actions/workflows/pint.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tapp/filament-value-range-filter.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-value-range-filter)

A value range filter for Filament table builder.

## Version Compatibility

 Filament | Filament Value Range Filter
:---------|:---------------------------
 3.x      | 1.x
 4.x      | 2.x

## Installation

You can install the package via composer:

### For Filament 3

```bash
composer require tapp/filament-value-range-filter:"^1.0"
```

### For Filament 4

```bash
composer require tapp/filament-value-range-filter:"^2.0"
```

Optionally, you can publish the translations files with:

```bash
php artisan vendor:publish --tag="filament-value-range-filter-translations"
```

## Appareance

![Filament Value Range Filters](https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filters.png)

<img align="left" alt="Filament Value Range Filter Options" title="Filament Value Range Filter Options" src="https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filter_range_options.png" width="45%" />

<img alt="Filament Value Range Filter Greater Than Option" title="Filament Value Range Filter Greater Than Option" src="https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filter_greater_than.png" width="45%" />

<br clear="left"/>

<br />

**Filter Indicators**

<img alt="Filament Value Range Filter Between Indicator" title="Filament Value Range Filter Between Indicator" src="https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filter_indicator.png" width="45%" />

<img alt="Filament Value Range Filter Greater Than Indicator" title="Filament Value Range Filter Greater Than Indicator" src="https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/greater_than_indicator.png" width="100%" />


## Usage

### Filter

Add to your Filament resource:

```php
use Tapp\FilamentValueRangeFilter\Filters\ValueRangeFilter;

public static function table(Table $table): Table
{
    return $table
        //...
        ->filters([
            ValueRangeFilter::make('project_value')
                    ->currency(),
            ValueRangeFilter::make('estimated_hours'),
            // ...
        ])
}
```

### Options

#### Currency

You may use the `->currency()` method to format the values on placeholder and filter indicator as currency. The default currency format is `USD`.

```php
ValueRangeFilter::make('project_value')
    ->currency(),
```

**Change the currency format**

The `->currencyCode()` and `->locale()` methods can be used to change the currency format.
You can pass one of the [ISO 4217 currency codes](https://www.iban.com/currency-codes) to the `->currencyCode()` method.

```php
ValueRangeFilter::make('project_value')
    ->currency()
    ->currencyCode('EUR')
    ->locale('fr'),
```

<img align="left" alt="Filament Value Range Filter Between currency in EUR Indicator" title="Filament Value Range Filter Between currency in EUR Indicator" src="https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/between_eur.png" width="40%" />

<img alt="Filament Value Range Filter Between currency in EUR" title="Filament Value Range Filter Between currency in EUR" src="https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filter_indicator_eur.png" width="45%" />

<br clear="left" />

**Currency value**

When using currency values, the filter assumes that the value stored on database that will be compared with the provided value on filter is in the smallest unit of the currency (e.g., cents for USD). Therefore, the value provided in the filter is by default multiplied by 100 to be compared with the value stored in the database.

If the values stored in your database are not in the currency's smallest unit and you do not need the value provided in the filter to be multiplied by 100, pass 'false' to the `->currencyInSmallestUnit()` method:

```php
ValueRangeFilter::make('project_value')
    ->currency()
    ->currencyInSmallestUnit(false),
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

If you discover any security-related issues, please email `security@tappnetwork.com`.

## Credits

-  [Tapp Network](https://github.com/TappNetwork)
-  [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
