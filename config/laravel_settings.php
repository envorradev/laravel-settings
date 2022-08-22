<?php

use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Actions\CreateNewSettingForUser;

return [
    'default_setting_type' => SettingType::APP,

    'settings_model' => Setting::class,

    'set_action' => CreateNewSettingForUser::class,
];
