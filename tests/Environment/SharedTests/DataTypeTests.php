<?php

namespace TaylorNetwork\LaravelSettings\Tests\Environment\SharedTests;

use TaylorNetwork\LaravelSettings\Enums\DataType;
use TaylorNetwork\LaravelSettings\Exceptions\DataTypeException;

trait DataTypeTests
{
    /**
     * @throws DataTypeException
     */
    protected function assertAllOfDataType(DataType $type, iterable $items, ?string $key = 'value'): void
    {
        foreach($items as $item) {
            $this->assertIsDataType($type, $key ? $item[$key] : $item);
        }
    }

    /**
     * @throws DataTypeException
     */
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
