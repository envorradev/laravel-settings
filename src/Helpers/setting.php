<?php

use TaylorNetwork\LaravelSettings\Enums\SettingType;

if(!function_exists('setting')) {
    function setting(string $key, mixed $default = null, ?SettingType $settingType = null): mixed
    {

    }
}
