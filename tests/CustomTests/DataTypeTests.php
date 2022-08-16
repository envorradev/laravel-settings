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
        $valueType = is_string($value) ? DataType::tryFrom($value) : null;

        if($valueType || $value instanceof DataType) {
            $this->assertTrue($type->is($valueType ?? $value));
        } else {
            $this->assertTrue($type->valueIsType($value));
        }
    }
}
