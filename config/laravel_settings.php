<?php

use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Enums\SettingType;

return [
    'default_setting_type' => SettingType::APP,

    'settings_model' => Setting::class,
];
