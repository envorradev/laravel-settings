<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\EnumTests;

use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Tests\TestCase;
use TaylorNetwork\LaravelSettings\Tests\Units\Package\SharedTests\EnumSharedTests;

class SettingTypeTest extends TestCase
{
    use EnumSharedTests;

    /** @test */
    public function it_has_values_method()
    {
        $this->assertValuesMethodWorks(SettingType::class);
    }

    /** @test */
    public function test_is_method_with_string()
    {
        $this->assertTrue(SettingType::APP->is('app'));
    }

    /** @test */
    public function test_is_method_with_instance()
    {
        $this->assertTrue(SettingType::GLOBAL->is(SettingType::GLOBAL));
    }

    /** @test */
    public function test_isIn_method_with_string_array()
    {
        $this->assertTrue(SettingType::GLOBAL->isIn([
            'model',
            'user',
            'global',
        ]));
    }

    /** @test */
    public function test_isIn_method_with_instance_array()
    {
        $this->assertTrue(SettingType::GLOBAL->isIn([
            SettingType::MODEL,
            SettingType::USER,
            SettingType::GLOBAL,
        ]));
    }

    /** @test */
    public function test_isIn_method_with_mixed_array()
    {
        $this->assertTrue(SettingType::GLOBAL->isIn([
            'model',
            '',
            SettingType::USER,
            null,
            'global',
        ]));
    }

    /** @test */
    public function test_make_method_with_string()
    {
        $type = SettingType::make('model');
        $this->assertInstanceOf(SettingType::class, $type);
        $this->assertTrue($type === SettingType::MODEL);
    }

    /** @test */
    public function test_make_method_with_instance()
    {
        $type = SettingType::make(SettingType::MODEL);
        $this->assertInstanceOf(SettingType::class, $type);
        $this->assertTrue($type === SettingType::MODEL);
    }

    /** @test */
    public function test_make_method_with_null()
    {
        $type = SettingType::make();
        $this->assertInstanceOf(SettingType::class, $type);
        $this->assertTrue($type === SettingType::APP);
    }
}
