<?php

namespace TaylorNetwork\LaravelSettings\Contracts;

/**
 * ProvidesArrayOfValues
 *
 * @package TaylorNetwork\LaravelSettings
 */
interface ProvidesArrayOfValues
{
    /**
     * Returns values of all cases in enum.
     *
     * @return array<string>
     */
    public static function values(): array;
}
