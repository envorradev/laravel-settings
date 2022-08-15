<?php

namespace TaylorNetwork\LaravelSettings\Repositories;

use TaylorNetwork\LaravelSettings\Enums\SettingType;

class ModelSettingsRepository extends SettingsRepository
{
    protected static ?SettingType $settingType = SettingType::MODEL;
}
