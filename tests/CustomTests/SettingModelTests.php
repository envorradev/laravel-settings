<?php

namespace TaylorNetwork\LaravelSettings\Tests\CustomTests;

use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Exceptions\DataTypeException;
use TaylorNetwork\LaravelSettings\Models\Setting;

trait SettingModelTests
{
    /**
     * @throws DataTypeException
     */
    protected function assertSettingIsValid(Setting $setting): void
    {
        $this->assertIsDataType($setting->getDataType(), $setting->value);
    }

    /**
     * @throws DataTypeException
     */
    protected function assertSettingsAreValid(SettingsCollection $collection): void
    {
        foreach($collection as $setting) {
            $this->assertSettingIsValid($setting);
        }
    }
}
