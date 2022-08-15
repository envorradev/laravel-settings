<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use TaylorNetwork\LaravelSettings\Enums\DataType;


interface DynamicallyCastsTypes
{
    /**
     * Get the DataType for this Model.
     *
     * @return DataType
     */
    public function getDataType(): DataType;
}
