<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\SharedTests;

use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Enums\SettingType;

trait RepositorySharedTests
{
    protected function assertAllOfSettingType(SettingType $settingType, SettingsCollection $collection): void
    {
        foreach($collection as $setting) {
            $this->assertTrue($settingType->is($setting->setting_type));
        }
    }
}
