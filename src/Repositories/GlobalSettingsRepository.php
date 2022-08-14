<?php

namespace TaylorNetwork\LaravelSettings\Repositories;

use TaylorNetwork\LaravelSettings\Enums\SettingType;

class GlobalSettingsRepository extends SettingsRepository
{
    protected static SettingType $repositorySettingType = SettingType::GLOBAL;
}
