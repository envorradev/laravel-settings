<?php

namespace TaylorNetwork\LaravelSettings\Enums;

use TaylorNetwork\LaravelSettings\Contracts\ProvidesArrayOfValues;
use TaylorNetwork\LaravelSettings\Traits\SharesEnumValues;

enum SettingType: string implements ProvidesArrayOfValues
{
    use SharesEnumValues;

    case GLOBAL = 'global';
    case APP = 'app';
    case MODEL = 'model';
    case USER = 'user';

    public function is(self|string|null $case): bool
    {
        $case = !$case instanceof self ? self::tryFrom($case) : $case;
        return $this === $case;
    }

    public function isIn(array $cases): bool
    {
        foreach($cases as $case) {
            if($this->is($case)) {
                return true;
            }
        }
        return false;
    }

    public static function make(SettingType|string|null $case = null): self
    {
        $case = !$case instanceof self && $case !== null ? self::tryFrom($case) : $case;
        return $case ?? self::APP;
    }
}
