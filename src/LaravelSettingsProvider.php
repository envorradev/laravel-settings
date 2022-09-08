<?php

namespace Envorra\LaravelSettings;

use Illuminate\Support\ServiceProvider;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

/**
 * LaravelSettingsProvider
 *
 * @package Envorra\LaravelSettings
 * @codeCoverageIgnore
 */
class LaravelSettingsProvider extends ServiceProvider
{
    /**
     * @return void
     * @noinspection PhpUnused
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom($this->packagePath('database/migrations'));

        $this->publishes([
            $this->packagePath('config/laravel_settings.php') => config_path('laravel_settings.php'),
        ], 'laravel-settings-config');

        include_once $this->packagePath('src/Helpers/setting.php');
    }

    /**
     * @inheritDoc
     * @noinspection PhpUnused
     */
    public function register()
    {
//        $this->app->bind('Setting', fn() => SettingsRepository::instance());
        $this->mergeConfigFrom($this->packagePath('config/laravel_settings.php'), 'laravel_settings');
    }

    /**
     * @param  string|null  $path
     * @return string
     * @internal
     */
    private function packagePath(?string $path = null): string
    {
        return __DIR__.'/..'.($path ? '/'.$path : '');
    }
}
