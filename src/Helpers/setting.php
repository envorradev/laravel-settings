<?php

use TaylorNetwork\LaravelSettings\Facades\Setting;

if (!function_exists('setting')) {
    /**
     * @param  string       $key
     * @param  mixed|null   $default
     * @param  string|null  $scope
     * @return mixed
     */
    function setting(string $key, mixed $default = null, ?string $scope = null): mixed
    {
        return Setting::scope($scope)->get($key, $default);
    }
}
