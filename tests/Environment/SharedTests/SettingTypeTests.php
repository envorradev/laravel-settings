<?php

namespace Envorra\LaravelSettings\Tests\Environment\SharedTests;

use Envorra\LaravelSettings\Collections\SettingsCollection;
use Envorra\LaravelSettings\Enums\SettingType;

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
