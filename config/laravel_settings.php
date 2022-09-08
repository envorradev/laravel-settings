<?php

use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\SettingTypes\AppSettingType;

return [
    'default_setting_type' => AppSettingType::class,

    'setting_model' => Setting::class,

    'column_map' => [],

    'morph_to_relation_name' => 'owner',

    'setting_type_directories' => [],
];
