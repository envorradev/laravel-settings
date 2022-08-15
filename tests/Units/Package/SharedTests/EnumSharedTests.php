<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\SharedTests;


trait EnumSharedTests
{
    protected function assertValuesMethodWorks(string $enum): void
    {
        $this->assertMethodExists($enum, 'values');
        $this->assertIsArray($enum::values());
        $this->assertSameSize($enum::cases(), $enum::values());
        $this->assertIsArrayOfStrings($enum::values());
    }
}
