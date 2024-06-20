# Filament Value Range Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tapp/filament-value-range-filter.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-value-range-filter)
![Code Style Action Status](https://github.com/TappNetwork/filament-value-range-filter/actions/workflows/pint.yml/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/tapp/filament-value-range-filter.svg?style=flat-square)](https://packagist.org/packages/tapp/filament-value-range-filter)

A value range filter for Laravel Filament.

## Installation

```bash
composer require tapp/filament-value-range-filter
```

Optionally, you can publish the translations files with:

```bash
php artisan vendor:publish --tag="filament-value-range-filter-translations"
```

## Appareance

![Filament Value Range Filters](https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filters.png)

![Filament Value Range Filter Between Indicator](https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filter_indicator.png)

![Filament Value Range Filter Options](https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filter_range_options.png)

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

![Filament Value Range Filter Between currency in EUR](https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/between_eur.png)

![Filament Value Range Filter Between currency in EUR Indicator](https://raw.githubusercontent.com/TappNetwork/filament-value-range-filter/main/docs/filter_indicator_eur.png)

**Currency value**

When using currency values, the filter assumes that the value stored on database that will be compared with the provided value on filter is in the smallest unit of the currency (e.g., cents for USD). Therefore, the value provided in the filter is by default multiplied by 100 to be compared with the value stored in the database.

If the values stored in your database are not in the currency's smallest unit and you do not need the value provided in the filter to be multiplied by 100, pass 'false' to the `->currencyInSmallestUnit()` method:

```php
ValueRangeFilter::make('project_value')
    ->currency()
    ->currencyInSmallestUnit(false),
```
