<?php

use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting;

return [
    'default_setting_type' => SettingType::APP,

    'settings_model' => Setting::class,
];
