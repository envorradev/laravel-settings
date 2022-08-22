<?php

namespace Envorra\LaravelSettings\Facades;

use Illuminate\Support\Facades\Facade;
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
