<?php

namespace Envorra\LaravelSettings\Contracts;

use Envorra\LaravelSettings\Enums\DataType;


/**
 * DynamicallyCastsTypes
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface DynamicallyCastsTypes
{
    /**
     * Get the DataType for this Model.
     *
     * @return DataType
     */
    public function getDataType(): DataType;
}
