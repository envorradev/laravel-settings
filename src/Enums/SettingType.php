<?php

namespace TaylorNetwork\LaravelSettings\Enums;

use TaylorNetwork\LaravelSettings\Contracts\ProvidesArrayOfValues;

/**
 * Class SettingType
 *
 * @package LaravelSettings
 */
enum SettingType: string implements ProvidesArrayOfValues
{
    case GLOBAL = 'global';
    case APP = 'app';
    case MODEL = 'model';
    case USER = 'user';

    /**
     * @inheritDoc
     */
    public static function values(): array
    {
        $values = [];
        foreach(self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }

    /**
     * Check if this type is same as given type.
     *
     * @param SettingType|string|null $case
     * @return bool
     */
    public function is(self|string|null $case): bool
    {
        $case = !$case instanceof self ? self::tryFrom($case) : $case;
        return $this === $case;
    }

    /**
     * Check if this type is in given types.
     *
     * @param array $cases
     * @return bool
     */
    public function isIn(array $cases): bool
    {
        foreach($cases as $case) {
            if($this->is($case)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Make a new instance from given.
     *
     * @param SettingType|string|null $case
     * @return static
     */
    public static function make(SettingType|string|null $case = null): self
    {
        $case = !$case instanceof self && $case !== null ? self::tryFrom($case) : $case;
        return $case ?? self::APP;
    }
}
