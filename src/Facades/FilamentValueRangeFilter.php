<?php

namespace Tapp\FilamentValueRangeFilter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tapp\FilamentValueRangeFilter\FilamentValueRangeFilter
 */
class FilamentValueRangeFilter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Tapp\FilamentValueRangeFilter\FilamentValueRangeFilter::class;
    }
}
