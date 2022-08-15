<?php

namespace TaylorNetwork\LaravelSettings\Repositories;

use TaylorNetwork\LaravelSettings\Enums\SettingType;

class AppSettingsRepository extends SettingsRepository
{
    /**
     * @inheritDoc
     */
    protected static ?SettingType $settingType = SettingType::APP;
}
