<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

interface ProvidesArrayOfValues
{
    /**
     * Returns values of all cases in enum.
     *
     * @return array<string>
     */
    public static function values(): array;
}
