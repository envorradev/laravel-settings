<?php

namespace Envorra\LaravelSettings\Contracts;

use Envorra\TypeHandler\Contracts\Castables\Stringable;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * SettingType
 *
 * @package Envorra\LaravelSettings\Contracts
 */
interface SettingType extends Scope, Stringable
{
    /**
     * @inheritDoc
     */
    public function apply(Builder $builder, Model $model): Builder;

    /**
     * @return string
     */
    public function settingTypeColumn(): string;

    /**
     * @return string
     */
    public function name(): string;
}
