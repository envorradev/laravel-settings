<?php

namespace Envorra\LaravelSettings\Tests\Environment\SharedTests;

use Envorra\LaravelSettings\Models\Setting;
use Envorra\LaravelSettings\Exceptions\DataTypeException;
use Envorra\LaravelSettings\Collections\SettingsCollection;

trait SettingModelTests
{
    protected function assertSettingIsValid(Setting $setting): void
    {
        $this->assertIsDataType($setting->getDataType(), $setting->value);
    }

    protected function assertSettingsAreValid(SettingsCollection $collection): void
    {
        foreach ($collection as $setting) {
            $this->assertSettingIsValid($setting);
        }
    }
}
