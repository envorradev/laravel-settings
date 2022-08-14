<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

use TaylorNetwork\LaravelSettings\Enums\DataType;


interface DynamicallyCastsTypes
{
    public function getDataType(): DataType;
}
