<?php

namespace Envorra\LaravelSettings\Tests\Unit\Collections;

use Envorra\LaravelSettings\Enums\DataType;
use Envorra\LaravelSettings\Tests\TestCase;
use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Collections\SettingsCollection;
use Envorra\LaravelSettings\Exceptions\CastCollectionException;

/**
 * @coversDefaultClass \Envorra\LaravelSettings\Collections\SettingsCollection
 */
class SettingsCollectionTest extends TestCase
{
    /**
     * @test
     * @covers ::fromArray
     * @covers \Envorra\LaravelSettings\Exceptions\CastCollectionException
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

        $this->expectException(CastCollectionException::class);
        SettingsCollection::fromArray(['empty']);
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
