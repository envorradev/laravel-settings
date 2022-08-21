<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\SharedTests;

use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Enums\SettingType;

trait EnumTests
{
    /**
     * @param  class-string<DataType|SettingType>  $enum
     * @return void
     */
    protected function checkEnumValuesMethod(string $enum): void
    {
        $values = [];
        foreach($enum::cases() as $case) {
            $values[] = $case->value;
        }

        $this->assertMethodExists($enum, 'values');
        $this->assertEquals($values, $enum::values());
    }

    /**
     * @param  class-string<DataType|SettingType>  $enum
     * @return void
     */
    protected function checkEnumIsMethod(string $enum): void
    {
        $cases = $enum::cases();
        $firstCase = $cases[0];

        $this->assertMethodExists($enum, 'is');
        $this->assertTrue($firstCase->is($cases[0]));
        $this->assertTrue($firstCase->is($cases[0]->value));
        $this->assertFalse($firstCase->is($cases[1]));
        $this->assertFalse($firstCase->is($cases[1]->value));
        $this->assertFalse($firstCase->is(null));
    }

    /**
     * @param  class-string<DataType|SettingType>  $enum
     * @return void
     */
    protected function checkEnumIsInMethod(string $enum): void
    {
        $cases = $enum::cases();
        $firstCase = $cases[0];
        $expectTrue = [
            $cases[1],
            $cases[1]->value,
            null,
            $cases[0]->value,
            $cases[0],
        ];
        $expectFalse = [
            null,
            'testing-value',
            'false-value',
            $cases[1],
        ];

        $this->assertMethodExists($enum, 'isIn');
        $this->assertTrue($firstCase->isIn($expectTrue));
        $this->assertFalse($firstCase->isIn($expectFalse));
        $this->assertFalse($firstCase->isIn([]));
    }
}
