<?php

namespace TaylorNetwork\LaravelSettings\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use TaylorNetwork\LaravelSettings\LaravelSettingsProvider;
use TaylorNetwork\LaravelSettings\Tests\Environment\database\seeders\TestingSeeder;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

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

    protected function assertIsArrayOfStrings(array $array): void
    {
        foreach($array as $item) {
            $this->assertIsString($item);
        }
    }

    protected function assertMethodExists($class, string $method): void
    {
        $this->assertTrue(method_exists($class, $method));
    }

    /** @test */
    public function test_environment_is_working()
    {
        $this->assertTrue(true);
    }
}
