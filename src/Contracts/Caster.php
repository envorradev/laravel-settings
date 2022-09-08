<?php

namespace Envorra\LaravelSettings\Contracts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Caster
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface Caster extends CastsAttributes
{
    /**
     * @inheritDoc
     */
    public function get($model, string $key, mixed $value, array $attributes): mixed;

    /**
     * @inheritDoc
     */
    public function set($model, string $key, mixed $value, array $attributes): string;
}
