<?php

namespace Envorra\LaravelSettings\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Envorra\LaravelSettings\LaravelSettingsProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Envorra\LaravelSettings\Facades\Setting as SettingFacade;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\UserSeeder;
use Envorra\LaravelSettings\Tests\Environment\Database\Seeders\SettingSeeder;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

//    use SharedTests;

    public function ignorePackageDiscoveriesFrom(): array
    {
        return [];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Environment/Database/Migrations');
    }

    protected function defineDatabaseSeeders(): void
    {
        $this->seed([
            SettingSeeder::class,
            UserSeeder::class,
        ]);
    }

    /** @noinspection SpellCheckingInspection */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function getPackageAliases($app): array
    {
        return [
            'SettingAlias' => SettingFacade::class,
        ];
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaravelSettingsProvider::class,
        ];
    }
}
