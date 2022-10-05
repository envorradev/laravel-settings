<?php

use Envorra\LaravelSettings\Facades\Setting;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

if (!function_exists('setting')) {
    /**
     * @param  string       $key
     * @param  mixed|null   $default
     * @param  string|null  $scope
     * @return mixed
     */
    function setting(string $key, mixed $default = null, ?string $scope = null): mixed
    {
        if ($scope) {
            $instance = Setting::$scope();
            if ($instance instanceof SettingsRepository) {
                return $instance->get($key, $default);
            }
        }

        return Setting::get($key, $default);
    }
}
