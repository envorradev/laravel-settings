<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\EnumTests;

use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Tests\TestCase;

class DataTypeTest extends TestCase
{
    /** @test */
    public function it_has_values_method()
    {
        $this->assertValuesMethodWorks(DataType::class);
    }

    // @todo more tests
}
