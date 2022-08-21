<?php

namespace TaylorNetwork\LaravelSettings\Tests\Unit\Collections;

use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

/**
 * @coversDefaultClass \TaylorNetwork\LaravelSettings\Collections\SettingsCollection
 */
class SettingsCollectionTest extends TestCase
{
    /**
     * @test
     * @covers ::fromArray
     */
    public function it_can_execute_fromArray_method(): void
    {
        $array = [
            [
                'key' => 'app.test.float1',
                'setting_type' => SettingType::APP,
                'data_type' => DataType::FLOAT,
                'value' => 7.5,
            ],
        ];

        $this->assertInstanceOf(SettingsCollection::class, SettingsCollection::fromArray($array));
    }

    /**
     * @test
     * @covers ::fromJson
     */
    public function it_can_execute_fromJson_method(): void
    {
        $json = '[{"key":"app.test.float1","setting_type":"app","data_type":"float","value":"7.5"}]';

        $this->assertInstanceOf(SettingsCollection::class, SettingsCollection::fromJson($json));
    }

    /**
     * @test
     * @covers ::from
     */
    public function it_can_execute_from_method(): void
    {
        $collection = collect([
            [
                'key' => 'app.test.float1',
                'setting_type' => SettingType::APP,
                'data_type' => DataType::FLOAT,
                'value' => 7.5,
            ],
        ]);

        $this->assertNotInstanceOf(SettingsCollection::class, $collection);
        $this->assertInstanceOf(SettingsCollection::class, SettingsCollection::from($collection));
    }
}
