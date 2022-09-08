<?php

namespace Envorra\LaravelSettings\Contracts;

use Envorra\TypeHandler\Contracts\Types\Type;

/**
 * HasDataType
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface HasDataType
{
    /**
     * @return Type
     */
    public function getDataType(): Type;
}
