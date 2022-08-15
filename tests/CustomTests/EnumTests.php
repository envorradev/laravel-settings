<?php

namespace TaylorNetwork\LaravelSettings\Tests\CustomTests;


trait EnumTests
{
    protected function assertValuesMethodWorks(string $enum): void
    {
        $this->assertMethodExists($enum, 'values');
        $this->assertIsArray($enum::values());
        $this->assertSameSize($enum::cases(), $enum::values());
        $this->assertAllStrings($enum::values());
    }
}
