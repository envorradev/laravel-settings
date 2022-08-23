<?php

use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Models\Setting;

return [
    'default_setting_type' => SettingType::APP,

    'settings_model' => Setting::class,
];
