<?php

namespace Envorra\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Envorra\LaravelSettings\Enums\SettingType;
use Envorra\LaravelSettings\Models\Setting as SettingModel;
use Envorra\LaravelSettings\Collections\SettingsCollection;
use Envorra\LaravelSettings\Repositories\SettingsRepository;

/**
 * Setting
 *
 * @package Envorra\LaravelSettings
 *
 * @mixin SettingsRepository
 */
class Setting extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Setting';
    }
}
