<?php

namespace TaylorNetwork\LaravelSettings\Tests\CustomTests;

use TaylorNetwork\LaravelSettings\Enums\DataType;

trait DataTypeTests
{
    protected function assertAllOfDataType(DataType $type, iterable $items, ?string $key = 'value'): void
    {
        foreach($items as $item) {
            $this->assertIsDataType($type, $key ? $item[$key] : $item);
        }
    }

    protected function assertIsDataType(DataType $type, mixed $value): void
    {
        $this->assertTrue($type->valueIsType($value));
    }
}
