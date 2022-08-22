<?php

namespace TaylorNetwork\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use TaylorNetwork\LaravelSettings\Enums\SettingType;
use TaylorNetwork\LaravelSettings\Models\Setting as SettingModel;
use TaylorNetwork\LaravelSettings\Collections\SettingsCollection;
use TaylorNetwork\LaravelSettings\Repositories\SettingsRepository;

/**
 * Setting
 *
 * @package TaylorNetwork\LaravelSettings
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
