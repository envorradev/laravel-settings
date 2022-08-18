<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\Enums;

use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

/**
 * @coversDefaultClass \TaylorNetwork\LaravelSettings\Enums\SettingType
 */
class SettingTypeTest extends TestCase
{
    /**
     * @test
     * @covers ::values
     */
    public function it_returns_array_of_backing_values(): void
    {
        $this->checkEnumValuesMethod(SettingType::class);
    }

    /**
     * @test
     * @covers ::isIn
     */
    public function it_returns_if_type_is_in_array(): void
    {
        $this->checkEnumIsInMethod(SettingType::class);
    }

    /**
     * @test
     * @covers ::make
     */
    public function it_returns_a_new_instance_based_on_input(): void
    {
        $this->assertEquals(SettingType::MODEL, SettingType::make('model'));
        $this->assertEquals(SettingType::GLOBAL, SettingType::make(SettingType::GLOBAL));
        $this->assertEquals(SettingType::APP, SettingType::make());
    }

    /**
     * @test
     * @covers ::is
     */
    public function it_returns_if_a_two_types_are_the_same(): void
    {
        $this->checkEnumIsMethod(SettingType::class);
    }
}
