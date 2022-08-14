<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\EnumTests\SharedTests;


trait TestValuesMethod
{
    protected function assertValuesMethodWorks(string $enum): void
    {
        $this->assertMethodExists($enum, 'values');
        $this->assertIsArray($enum::values());
        $this->assertSameSize($enum::cases(), $enum::values());
        $this->assertIsArrayOfStrings($enum::values());
    }
}
