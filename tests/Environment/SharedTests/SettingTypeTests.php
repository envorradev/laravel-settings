<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\SharedTests;

use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\SettingType;

trait SettingTypeTests
{
    protected function assertAllOfSettingType(SettingType $settingType, iterable $items): void
    {
        foreach($items as $setting) {
            $this->assertIsSettingType($settingType, $setting->setting_type);
        }
    }

    protected function assertIsSettingType(SettingType $settingType, mixed $value): void
    {
        $this->assertTrue($settingType->is($value));
    }
}
