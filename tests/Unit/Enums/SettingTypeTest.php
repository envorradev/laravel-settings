<?php

namespace Envorra\LaravelSettings\Tests\Unit\Enums;

use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Enums\SettingType;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Enums\SettingType
 */
class SettingTypeTest extends TestCase
{
    /**
     * @test
     * @covers ::isIn
     */
    public function it_can_execute_isIn_method(): void
    {
        $this->checkEnumIsInMethod(SettingType::class);
    }

    /**
     * @test
     * @covers ::is
     */
    public function it_can_execute_is_method(): void
    {
        $this->checkEnumIsMethod(SettingType::class);
    }

    /**
     * @test
     * @covers ::values
     */
    public function it_can_execute_static_values_method(): void
    {
        $this->checkEnumValuesMethod(SettingType::class);
    }

    /**
     * @test
     * @covers ::make
     */
    public function it_can_make_instance_from_SettingType(): void
    {
        $this->assertEquals(SettingType::GLOBAL, SettingType::make(SettingType::GLOBAL));
    }

    /**
     * @test
     * @covers ::make
     */
    public function it_can_make_instance_from_null(): void
    {
        $this->assertEquals(SettingType::APP, SettingType::make());
    }

    /**
     * @test
     * @covers ::make
     */
    public function it_can_make_instance_from_string(): void
    {
        $this->assertEquals(SettingType::MODEL, SettingType::make('model'));
    }
}
