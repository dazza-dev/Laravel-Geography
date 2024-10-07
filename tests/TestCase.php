<?php

namespace DazzaDev\Geography\Tests;

use DazzaDev\Geography\GeographyServiceProvider;
use DazzaDev\Geography\Models\Continent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    /**
     * Get package providers.
     */
    protected function getPackageProviders($app)
    {
        return [
            GeographyServiceProvider::class,
        ];
    }

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Migrate
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->artisan('migrate')->run();
        $this->loadDataFromJson();
    }

    protected function loadDataFromJson()
    {
        $jsonPath = __DIR__.'/../database/data/continents.json';

        // Check if JSON file exists
        if (File::exists($jsonPath)) {
            $continents = json_decode(File::get($jsonPath), true);
            Continent::insert($continents);
        } else {
            throw new \Exception("JSON file not found at: $jsonPath");
        }
    }
}
