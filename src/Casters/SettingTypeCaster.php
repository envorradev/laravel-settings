<?php

namespace Envorra\LaravelSettings\Casters;

use Envorra\LaravelSettings\Contracts\Caster;
use Envorra\LaravelSettings\Contracts\SettingType;
use Envorra\LaravelSettings\Resolvers\SettingTypeResolver;

/**
 * SettingTypeCaster
 *
 * @package Envorra\LaravelSettings\Casters
 */
class SettingTypeCaster implements Caster
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, mixed $value, array $attributes): mixed
    {
        return SettingTypeResolver::resolve($value ?? '') ?? $value;
    }

    /**
     * @inheritDoc
     */
    public function set($model, string $key, mixed $value, array $attributes): string
    {
        if ($value instanceof SettingType) {
            return $value->name();
        }

        return (string) $value;
    }

}
