<?php

namespace TaylorNetwork\LaravelSettings\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use TaylorNetwork\LaravelSettings\LaravelSettingsProvider;
use TaylorNetwork\LaravelSettings\Tests\CustomTests\SharedTests;
use TaylorNetwork\LaravelSettings\Tests\Environment\Database\Seeders\TestingSeeder;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;
    use SharedTests;

    public function ignorePackageDiscoveriesFrom(): array
    {
        return [];
    }

    protected function getPackageAliases($app): array
    {
        return [];
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelSettingsProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function defineDatabaseSeeders(): void
    {
        $this->seed(TestingSeeder::class);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Environment/database/migrations');
    }


    /** @test */
    public function test_environment_is_working()
    {
        $this->assertTrue(true);
    }
}
