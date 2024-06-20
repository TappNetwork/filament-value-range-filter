<?php

namespace Tapp\FilamentValueRangeFilter\Tests;

use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Tapp\FilamentValueRangeFilter\FilamentValueRangeFilterServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FilamentValueRangeFilterServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
