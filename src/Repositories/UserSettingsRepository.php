<?php

namespace TaylorNetwork\LaravelSettings\Repositories;

use TaylorNetwork\LaravelSettings\Enums\SettingType;

class UserSettingsRepository extends SettingsRepository
{
    protected static ?SettingType $settingType = SettingType::USER;
}
