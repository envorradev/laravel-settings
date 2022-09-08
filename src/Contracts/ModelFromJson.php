<?php

namespace Envorra\LaravelSettings\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * ModelFromJson
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface ModelFromJson
{
    /**
     * @param  string  $json
     * @return Model|null
     */
    public static function modelFromJson(string $json): ?Model;
}
