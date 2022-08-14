<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

interface ProvidesArrayOfValues
{
    /**
     * @return array<string>
     */
    public static function values(): array;
}
