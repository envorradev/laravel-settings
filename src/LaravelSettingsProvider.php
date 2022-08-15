<?php

namespace TaylorNetwork\LaravelSettings;

use Illuminate\Support\ServiceProvider;

class LaravelSettingsProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mergeConfigFrom($this->packagePath('config/laravel_settings.php'), 'laravel_settings');
    }

    public function boot()
    {
        $this->loadMigrationsFrom($this->packagePath('database/migrations'));

        $this->publishes([
            $this->packagePath('config/laravel_settings.php') => config_path('laravel_settings.php'),
        ]);
    }

    private function packagePath(?string $path = null): string
    {
        return __DIR__.'/..'.($path ? '/'.$path : '');
    }
}
