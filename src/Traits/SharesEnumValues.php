<?php

namespace TaylorNetwork\LaravelSettings\Traits;

trait SharesEnumValues
{
    /**
     * @inheritDoc
     */
    public static function values(): array
    {
        $values = [];
        foreach(static::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }
}
