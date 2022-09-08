<?php

namespace Envorra\LaravelSettings\Casters;

use Envorra\TypeHandler\Contracts\Types\Type;
use Envorra\LaravelSettings\Contracts\Caster;
use Envorra\TypeHandler\Factories\TypeFactory;
use Envorra\TypeHandler\Exceptions\TypeFactoryException;

/**
 * DataTypeCaster
 *
 * @package Envorra\LaravelSettings
 */
class DataTypeCaster implements Caster
{
    /**
     * @inheritDoc
     * @throws TypeFactoryException
     */
    public function get($model, string $key, mixed $value, array $attributes = []): mixed
    {
        return TypeFactory::createFromType($value);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, mixed $value, array $attributes = []): string
    {
        if($value instanceof Type) {
            return $value::type();
        }

        return $value;
    }
}
