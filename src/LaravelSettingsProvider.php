<?php

namespace Envorra\LaravelSettings;

use Illuminate\Support\ServiceProvider;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

/**
 * LaravelSettingsProvider
 *
 * @package Envorra\LaravelSettings
 */
class LaravelSettingsProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom($this->packagePath('database/migrations'));

        $this->publishes([
            $this->packagePath('config/laravel_settings.php') => config_path('laravel_settings.php'),
        ]);

        include_once $this->packagePath('src/Helpers/setting.php');
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mergeConfigFrom($this->packagePath('config/laravel_settings.php'), 'laravel_settings');
        $this->app->bind('Setting', SettingsRepository::class);
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
