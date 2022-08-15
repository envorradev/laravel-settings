<?php

namespace TaylorNetwork\LaravelSettings\Repositories;

use TaylorNetwork\LaravelSettings\Enums\SettingType;

class UserSettingsRepository extends SettingsRepository
{
    /**
     * @inheritDoc
     */
    protected static ?SettingType $settingType = SettingType::USER;
}
