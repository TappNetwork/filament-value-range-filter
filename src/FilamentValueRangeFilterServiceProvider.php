<?php

namespace Tapp\FilamentValueRangeFilter;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentValueRangeFilterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-value-range-filter')
            ->hasConfigFile()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        //
    }
}
