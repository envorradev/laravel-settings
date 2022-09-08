<?php

namespace Envorra\LaravelSettings\SettingTypes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Contracts\SettingType;

/**
 * AbstractSettingType
 *
 * @package Envorra\LaravelSettings\SettingTypes
 */
abstract class AbstractSettingType implements SettingType
{
    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model): Builder
    {
        return $builder->where($this->settingTypeColumn(), $this->name());
    }

    /**
     * @inheritDoc
     */
    public function settingTypeColumn(): string
    {
        return 'setting_type';
    }

    /**
     * @inheritDoc
     */
    public function toString(): string
    {
        return $this->name();
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @inheritDoc
     */
    public function name(): string
    {
        $type = str_replace('SettingType', '', class_basename($this));
        return strtolower($type[0]).substr($type, 1);
    }
}
