<?php

namespace TaylorNetwork\LaravelSettings\Tests\Units\Package\EnumTests;

use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Tests\TestCase;
use TaylorNetwork\LaravelSettings\Tests\Units\Package\EnumTests\SharedTests\TestValuesMethod;

class DataTypeTest extends TestCase
{
    use TestValuesMethod;

    /** @test */
    public function it_has_values_method()
    {
        $this->assertValuesMethodWorks(DataType::class);
    }
}
