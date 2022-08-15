<?php

use TaylorNetwork\LaravelSettings\Facades\Setting;

if(!function_exists('setting')) {
    function setting(string $key, mixed $default = null, ?string $scope = null): mixed
    {
        return Setting::scope($scope)->get($key, $default);
    }
}
