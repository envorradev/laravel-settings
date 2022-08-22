<?php

namespace Envorra\LaravelSettings\Tests;

use Envorra\LaravelSettings\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Envorra\LaravelSettings\LaravelSettingsProvider;
use Envorra\LaravelSettings\Facades\Setting as SettingFacade;
use Envorra\LaravelSettings\Repositories\SettingsRepository;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\ModelSeeder;
use Envorra\LaravelSettings\Tests\Environment\SharedTests\SharedTests;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\SettingsSeeder;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\AppSettingsSeeder;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\UserSettingsSeeder;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\ModelSettingsSeeder;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\GlobalSettingsSeeder;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\UserUsingTraitSeeder;

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
        return [
            'SettingAlias' => SettingFacade::class
        ];
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
        // Seed setting types
        $this->seed([
            AppSettingsSeeder::class,
            GlobalSettingsSeeder::class,
            ModelSettingsSeeder::class,
            UserSettingsSeeder::class,
        ]);

        // Seed models
        $this->seed([
            UserUsingTraitSeeder::class,
        ]);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Environment/database/migrations');
    }

    public function test_environment_is_working()
    {
        $this->assertTrue(true);
    }

    public function test_settings_seeded()
    {
        $this->assertDatabaseCount('settings', SettingsSeeder::groupSeedCount());
    }

    public function test_models_seeded()
    {
        $this->assertDatabaseCount('users', UserUsingTraitSeeder::seedCount());
    }
}
