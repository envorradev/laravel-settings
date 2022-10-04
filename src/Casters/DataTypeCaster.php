<?php

namespace Envorra\LaravelSettings\Casters;

use Envorra\TypeHandler\Contracts\Types\Type;
use Envorra\LaravelSettings\Contracts\Caster;
use Envorra\TypeHandler\Resolvers\TypeResolver;

/**
 * DataTypeCaster
 *
 * @package Envorra\LaravelSettings
 */
class DataTypeCaster implements Caster
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, mixed $value, array $attributes = []): mixed
    {
        return TypeResolver::resolveType($value);
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, mixed $value, array $attributes = []): string
    {
        if ($value instanceof Type) {
            return $value::type();
        }

        return $value;
    }
}
