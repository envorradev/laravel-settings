<?php

namespace Envorra\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * ModelFromArray
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface ModelFromArray
{
    /**
     * @param  array  $attributes
     * @return Model|null
     */
    public static function modelFromArray(array $attributes): ?Model;
}
